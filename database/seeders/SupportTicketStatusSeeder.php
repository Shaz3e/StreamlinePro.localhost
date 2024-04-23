<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportTicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticketStatuses = [
            [
                'name' => 'Open',
                'slug' => 'open',
                'description' => 'This status indicates that a new support ticket has been created and is awaiting attention from a support agent.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Progress',
                'slug' => 'in-progress',
                'description' => 'The ticket is assigned to a support agent, and they are actively working on resolving the issue or addressing the request.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'On Hold',
                'slug' => 'on-hold',
                'description' => 'Sometimes, a ticket may need to be temporarily put on hold due to various reasons, such as waiting for more information from the customer or waiting for a specific event to occur.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pending Customer Response',
                'slug' => 'pending-customer-response',
                'description' => 'This status indicates that the support team is waiting for additional information or a response from the customer to proceed with the ticket resolution.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Escalated',
                'slug' => 'escalated',
                'description' => 'If a support issue cannot be resolved at the current support agent\'s level, it may be escalated to a higher-tier support or management for further attention.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Closed',
                'slug' => 'closed',
                'description' => 'The support ticket has been successfully resolved, and the customer has been informed. It\'s considered completed.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reopened',
                'slug' => 'reopened',
                'description' => 'In cases where the customer reports that the issue has reoccurred or was not resolved satisfactorily, a closed ticket may be reopened for further investigation.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canceled',
                'slug' => 'canceled',
                'description' => 'If a ticket is no longer relevant or the customer\'s request has changed, it may be canceled without resolution.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Duplicate',
                'slug' => 'duplicate',
                'description' => 'When multiple tickets are opened for the same issue or request, one of them may be marked as a duplicate and closed to avoid redundancy.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Awaiting Approval',
                'slug' => 'awaiting-approval',
                'description' => 'Some support tickets may require approval from a supervisor or manager before proceeding with a resolution. This status is used while waiting for that approval.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Review',
                'slug' => 'in-review',
                'description' => 'After a support ticket is resolved, it may go into a review process to ensure that the solution provided meets quality standards.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Scheduled',
                'slug' => 'scheduled',
                'description' => 'For tickets that involve scheduling a future action or service, such as an appointment or maintenance, this status is used to indicate the scheduled date and time.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('support_ticket_statuses')->insert($ticketStatuses);
    }
}
