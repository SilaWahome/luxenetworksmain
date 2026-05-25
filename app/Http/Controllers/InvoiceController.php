<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('items')->orderBy('id', 'desc')->get();
        
        $stats = [
            'ksh_owed' => Invoice::where('currency', 'KSH')->where('is_cleared', false)->sum('total_amount') - Invoice::where('currency', 'KSH')->where('is_cleared', false)->sum('paid_amount'),
            'ugx_owed' => Invoice::where('currency', 'UGX')->where('is_cleared', false)->sum('total_amount') - Invoice::where('currency', 'UGX')->where('is_cleared', false)->sum('paid_amount'),
            'ksh_income' => Invoice::where('currency', 'KSH')->sum('paid_amount'),
            'ugx_income' => Invoice::where('currency', 'UGX')->sum('paid_amount'),
        ];

        return view('admin.invoices.index', compact('invoices', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'person_name' => 'nullable|string',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'currency' => 'required|in:KSH,UGX',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'client_logo' => 'nullable|image|max:10240',
        ]);

        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $invoiceNumber = 'LUX-' . str_pad($nextId, 2, '0', STR_PAD_LEFT);

        $clientLogoPath = null;
        if ($request->hasFile('client_logo')) {
            $clientLogoPath = $request->file('client_logo')->store('client_logos', 'public');
        }

        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'company_name' => $request->company_name,
            'person_name' => $request->person_name,
            'date' => $request->date,
            'due_date' => $request->due_date,
            'currency' => $request->currency,
            'client_logo' => $clientLogoPath,
        ]);

        $totalAmount = 0;
        foreach ($request->items as $item) {
            $itemTotal = $item['quantity'] * $item['unit_price'];
            $invoice->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $itemTotal,
            ]);
            $totalAmount += $itemTotal;
        }

        $invoice->update(['total_amount' => $totalAmount]);

        return back()->with('success', 'Invoice generated successfully: ' . $invoiceNumber);
    }

    public function download(Invoice $invoice)
    {
        $invoice->load('items');
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));
        return $pdf->download($invoice->invoice_number . '.pdf');
    }

    public function updatePayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $newPaidAmount = $invoice->paid_amount + $request->paid_amount;
        
        $status = 'unpaid';
        if ($newPaidAmount >= $invoice->total_amount) {
            $status = 'paid';
            $newPaidAmount = $invoice->total_amount;
        } elseif ($newPaidAmount > 0) {
            $status = 'partially_paid';
        }

        $invoice->update([
            'paid_amount' => $newPaidAmount,
            'status' => $status,
        ]);

        return back()->with('success', 'Payment updated.');
    }

    public function clear(Invoice $invoice)
    {
        $invoice->update(['is_cleared' => true]);
        return back()->with('success', 'Invoice marked as cleared and moved to income.');
    }
}
