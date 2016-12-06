function goToApp(messageID) {
    var now = new Date().valueOf();
	setTimeout(function () {
	    if (new Date().valueOf() - now > 100) return;
	    window.open("https://itunes.apple.com/messageservice?id="+messageID, '_blank');
	}, 25);
	window.location = "messageservice://id="+messageID;
}