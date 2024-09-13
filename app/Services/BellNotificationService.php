<?php

namespace App\Services;

use App\Models\Notification;

class BellNotificationService
{
    /**
     * Notify a specific admin (staff) by their ID.
     *
     * @param  int     $adminId   The ID of the admin to notify
     * @param  string  $title     Title of the notification
     * @param  string  $message   Message body of the notification
     * @param  int     $modelId   Model ID for reference (optional)
     * @param  string  $model     Model name (optional)
     * @param  string  $action    The action (optional, default 'index')
     */
    public function notifyStaff($adminId, $title, $message, $modelId = null, $model = null, $action = 'index')
    {
        // Construct the route for admin staff
        $routeName = "admin.{$model}.{$action}";

        // Notify the specific admin
        Notification::create([
            'admin_id'   => $adminId,
            'title'      => $title,
            'message'    => $message,
            'type'       => $model,
            'model_id'   => $modelId,
            'route_name' => $routeName,
        ]);
    }

    /**
     * Notify a specific user by their ID.
     *
     * @param  int     $userId    The ID of the user to notify
     * @param  string  $title     Title of the notification
     * @param  string  $message   Message body of the notification
     * @param  int     $modelId   Model ID for reference (optional)
     * @param  string  $model     Model name (optional)
     * @param  string  $action    The action (optional, default 'index')
     */
    public function notifyUser($userId, $title, $message, $modelId = null, $model = null, $action = 'index')
    {
        // Construct the route for user
        $routeName = "{$model}.{$action}";

        // Notify the specific user
        Notification::create([
            'user_id'    => $userId,
            'title'      => $title,
            'message'    => $message,
            'type'       => $model,
            'model_id'   => $modelId,
            'route_name' => $routeName,
        ]);
    }

    /**
     * Notify the system (superadmin) with a default ID of 1.
     *
     * @param  string  $title     Title of the notification
     * @param  string  $message   Message body of the notification
     * @param  int     $modelId   Model ID for reference (optional)
     * @param  string  $model     Model name (optional)
     * @param  string  $action    The action (optional, default 'index')
     */
    public function notifySystem($title, $message, $modelId = null, $model = null, $action = 'index')
    {
        // Notify the superadmin with ID = 1
        $this->notifyStaff(1, $title, $message, $modelId, $model, $action);
    }
}
