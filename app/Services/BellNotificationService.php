<?php

namespace App\Services;

use App\Models\Notification;

class BellNotificationService
{
    /**
     * Add a notification to the database dynamically for both admins and users.
     *
     * @param  string  $role      Either 'admin' or 'user' to differentiate the roles
     * @param  int     $id        The admin_id or user_id based on the role
     * @param  string  $title     Title of the notification
     * @param  string  $message   Message body of the notification
     * @param  int     $modelId   Model ID for reference (e.g., a post, invoice, etc.)
     * @param  string  $model     Model name (also used as type, e.g., 'invoice', 'order', etc.)
     * @param  string  $action    The action (e.g., 'show', 'edit', 'delete')
     * @return Notification
     */
    public function notify($role, $id, $title, $message, $modelId = null, $model = null, $action = 'index')
    {
        // Construct the route name dynamically based on role, model, and action
        $routeName = ($role === 'admin')
            ? "admin.{$model}.{$action}" // For admin: 'admin.model.action'
            : "{$model}.{$action}";      // For user: 'model.action'

        // Create the notification, dynamically setting the admin_id or user_id
        $notification = Notification::create([
            ($role === 'admin') ? 'admin_id' : 'user_id' => $id, // Dynamically set ID based on role
            'title'      => $title,
            'message'    => $message,
            'type'       => $model, // Use the model name as the type
            'model_id'   => $modelId,
            'route_name' => $routeName,
        ]);

        return $notification;
    }
}
