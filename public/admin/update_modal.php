<!-- Update modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="admin_update.php" id="updateEventForm" enctype="multipart/form-data">
                    <input type="hidden" id="updateEventId" name="event_id">
                    <div class="mb-3">
                        <label for="updateEventName" class="form-label">Event Name</label>
                        <input type="text" id="updateEventName" name="event_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateEventDescription" class="form-label">Event Description</label>
                        <textarea id="updateEventDescription" name="event_description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="updateEventImage" class="form-label">Choose Image</label>
                        <input type="file" class="form-control" id="updateEventImage" name="file" accept="image/*">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark" id="saveChanges">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>