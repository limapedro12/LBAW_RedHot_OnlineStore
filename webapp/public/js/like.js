const pusher = new Pusher("7a447c0e0525f5f86bc9", {
    cluster: "eu",
    encrypted: true
})

const channel = pusher.subscribe('RedHot');
channel.bind('notification-productlike', function(data) {
    console.log(`New notification: ${data.message}`)
})
