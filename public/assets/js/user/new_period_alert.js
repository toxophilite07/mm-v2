document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Reminder',
        text: "Your estimated period date is today. Has your period started?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Send an AJAX request to automatically add the period record
            fetch('/user/auto-add-period', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    menstruation_period: '{{ $estimated_next_period }}',
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: 'Your period has been recorded.',
                        icon: 'success'
                    }).then(() => {
                        location.reload(); // Refresh the page to update the data
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
            });
        } else {
            Swal.fire('Reminder', "We'll remind you later.", 'info');
        }
    });
});