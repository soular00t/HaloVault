function dewWebSocket(establish) {
    var Socket = null;
    this.connect = function (establish) {
        if (establish) {
            if ("WebSocket" in window || "MozWebSocket" in window) {
                window.WebSocket = window.WebSocket || window.MozWebSocket;
                Socket = new WebSocket("ws://127.0.0.1:11776", "dew-rcon");
                return;
            }
        }
    };
    this.send = function (data) {
        try {
            if (Socket && Socket.OPEN) {
                Socket.send(data);
            }
        } catch (e) {
            console.log(" > Exception: " + e.message);
            Socket = null;
        }
    };
    this.close = function () {
        if (Socket) {
            try {
                Socket.close();
                Socket = null;
            }
            catch (e) {
                console.log(" > Exception: " + e.message);
                Socket = null;
            }
        }
    };

    this.connect(establish);

}