<?php 
function sessionfetch() {
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];

        if (is_string($errors)) {
            $errors = ['type' => 'error', 'message' => $errors];
        } elseif (is_array($errors)) {
            $errors = ['type' => 'error', 'message' => json_encode($errors)];
        } else {
            $errors = ['type' => 'error', 'message' => 'Unexpected error format'];
        }

        unset($_SESSION['errors']);

        echo json_encode([
            'success' => false,
            'data' => $errors
        ]);
        return; 
    } 
    
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];

        if (is_string($success)) {
            $success = ['type' => 'success', 'message' => $success];
        } elseif (is_array($success)) {
            $success = ['type' => 'success', 'message' => json_encode($success)];
        } else {
            $success = ['type' => 'success', 'message' => 'Unexpected success format'];
        }

        unset($_SESSION['success']);

        echo json_encode([
            'success' => true,
            'data' => $success
        ]);
        return;
    }

  exit();
}

sessionfetch();
