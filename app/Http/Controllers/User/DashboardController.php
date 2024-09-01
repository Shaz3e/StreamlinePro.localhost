<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\ProductService;
use App\Models\Promotion;
use App\Models\SupportTicketReply;

class DashboardController extends Controller
{
    public function dashboard()
    {

        // Fetch active promotions
        $promotions = Promotion::where('is_active', 1)
            ->orderBy('is_featured', 'desc')
            ->latest()
            ->get();

        // Get Currency
        $currency = currency(DiligentCreators('currency'));

        // Fetch Products
        // $products = ProductService::with('product')->where('is_active', 1)->get();
        $products = auth()->user()->products;

        // Fetch User Recent Invocies
        $recentInvoices = auth()->user()->invoices()
            ->where('is_published', true)
            ->where('status', '!=', Invoice::STATUS_PAID)
            ->where('published_on', '<', now())
            ->latest()
            ->take(10)
            ->get();

        // Fetch User Recently Paid Invoices
        $recentlyPaidInvoices = auth()->user()->invoices()
            ->where('status', Invoice::STATUS_PAID)
            ->latest()
            ->take(10)
            ->get();

        // Fetch the 10 most recent payments related to the user's invoices
        $recentPayments = Payment::whereIn('invoice_id', auth()->user()->invoices->pluck('id'))
            ->latest()
            ->take(10)
            ->get();

        // Fetch the 10 most recent support ticket related to the user's supportTickets relationship
        $supportTickets = auth()->user()->supportTickets()
            ->where('is_internal', false)
            ->latest()
            ->take(10)
            ->get();

        // Fetch the 10 most recent replies support tickets related to user's supportTickets relationship
        $supportTicketReplies = SupportTicketReply::with('client')
            ->whereHas('supportTicket', function ($query) {
                $query->where('is_internal', false);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('user.dashboard', [
            'promotions' => $promotions,
            'currency' => $currency,
            'products' => $products,
            'recentInvoices' => $recentInvoices,
            'recentlyPaidInvoices' => $recentlyPaidInvoices,
            'recentPayments' => $recentPayments,
            'supportTickets' => $supportTickets,
            'supportTicketReplies' => $supportTicketReplies
        ]);
    }
}
