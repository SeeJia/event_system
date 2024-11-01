function populateUpdateModal(event) {
  
    document.getElementById('updateEventId').value = event.event_id;
    document.getElementById('updateEventName').value = event.event_name;
    document.getElementById('updateEventDescription').value = event.event_description;

    if (!event.event_name || !event.event_description) {
        alert('Event Name and Description cannot be empty.');
        return false;
    }
}