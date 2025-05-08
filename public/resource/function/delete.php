<?php 
function showproj(){
    global $sql; 
    // Fixed the typo from "proejects" to "projects"
    $data = "SELECT * FROM projects ORDER BY id DESC"; 
    $stmt = $sql->prepare($data);
    $stmt->execute();
    
    // Fetch the results as an associative array
    $projec = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(empty($projec)) {
        echo '<div class="empty-message">No projects found. Upload your first project!</div>';
    } else {
    echo '<table>
        <tr>
        <th>id</th>
        <th>title</th>
        <th>action</th>
        </tr>';
    
    foreach($projec as $project){
        echo '<tr>';
        echo "<td>". $project['id'] . "</td>";
        echo "<td>". $project['title'] . "</td>";
        echo "<td><form method='post'>
                <input type='hidden' name='delete_id' value='" . $project['id'] . "'>
                <button type='submit' name='delete' class='delete-btn'>
                    <i class='bi bi-trash'></i> Delete
                </button>
            </form>
        </td>";
        echo '</tr>';
    }
    
    echo '</table>';
}
    
    // Handle delete action
    if(isset($_POST['delete']) && !empty($_POST['delete_id'])) {
        $id = intval($_POST['delete_id']);
        try {
            // First get the cover path to delete the file
            $get_query = "SELECT cover_path FROM projects WHERE id = :id";
            $get_stmt = $sql->prepare($get_query);
            $get_stmt->bindParam(':id', $id);
            $get_stmt->execute();
            $project = $get_stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($project && !empty($project['cover_path'])) {
                $file_path = $_SERVER['DOCUMENT_ROOT'] . $project['cover_path'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            // Then delete from database
            $delete_query = "DELETE FROM projects WHERE id = :id";
            $delete_stmt = $sql->prepare($delete_query);
            $delete_stmt->bindParam(':id', $id);
            $delete_stmt->execute();
            
            // Redirect to avoid resubmission
            echo "<script>window.location.href = window.location.pathname;</script>";
        } catch(PDOException $e) {
            echo "<div class='error-message'>Error deleting project: " . $e->getMessage() . "</div>";
        }
    }
}
?>
