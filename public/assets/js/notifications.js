document.addEventListener('DOMContentLoaded', function() {
    const femaleNotificationSound = new Audio('/assets/sounds/new_female_user.mp3');
    const healthWorkerNotificationSound = new Audio('/assets/sounds/new_health_worker.mp3');

    let previousFemaleCount = 0;  // Track previous female user count
    let previousHealthWorkerCount = 0;  // Track previous health worker count

    // Assume this variable is set based on the logged-in user's role
    const isAdmin = document.body.dataset.userRole === 'admin'; // Adjust this as needed

    function playNotificationSound(type) {
        if (!isAdmin) return; // Do not play sound if not admin

        if (type === 'female') {
            femaleNotificationSound.currentTime = 0;  // Reset to start
            femaleNotificationSound.play();  // Play sound
        } else if (type === 'health_worker') {
            healthWorkerNotificationSound.currentTime = 0;  // Reset to start
            healthWorkerNotificationSound.play();  // Play sound
        }
    }

    function checkNotifications() {
        fetch('/api/check-notifications')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Check for new female users
                if (data.new_female_users > previousFemaleCount) {
                    playNotificationSound('female');
                    updateNotificationUI('female', data.new_female_users);
                }

                // Check for new health workers
                if (data.new_health_workers > previousHealthWorkerCount) {
                    playNotificationSound('health_worker');
                    updateNotificationUI('health_worker', data.new_health_workers);
                }

                // Update previous counts
                previousFemaleCount = data.new_female_users;
                previousHealthWorkerCount = data.new_health_workers;
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
            });
    }

    function updateNotificationUI(type, count) {
        if (type === 'female') {
            document.querySelector('.notification_count').textContent = `${count} New Female Users`;
        } else if (type === 'health_worker') {
            document.querySelector('.notification_count').textContent = `${count} New Health Workers`;
        }
    
        document.getElementById('notification_indicator').style.display = 'block';
    }
    
    setInterval(checkNotifications, 1000);  // Check notifications every second (adjust as needed)
});
