<!--add Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="admin_add.php" id="addEventForm" enctype="multipart/form-data">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                    <div class="mb-3">
                        <label for="eventName" class="form-label">Event Name</label>
                        <input type="text" name="event_name" class="form-control" id="eventName" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Event Description</label>
                        <textarea name="event_description" class="form-control" id="eventDescription" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file">Choose Image:</label>
                        <input type="file" class="form-control" id="file" name="file" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark" id="saveEvent">ADD EVENT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>