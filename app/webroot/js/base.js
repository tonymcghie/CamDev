function setUp(){
    var takePicture = document.querySelectorAll(".take-picture"),
        ids = document.querySelectorAll(".ids");

    for (var i=0 ; i<takePicture.length ; i++){
        if (takePicture[i]) {
            // Set events
            takePicture[i].onchange = function (event) {
                // Get a reference to the taken picture or chosen file
                handelPicture(i,event);
            };
        }
    }
}

function handelPicture(i,event){
            //showPicture = document.querySelectorAll(".show-picture")[i-1];
            //alert(showPicture + " : " + i + " : " + showPicture.length);
// Get a reference to the taken picture or chosen file
            var showPicture = document.getElementById("show-picture"+event.target.id);

            var files = event.target.files,
                file;
            if (files && files.length > 0) {
                file = files[0];
                try {
                    // Get window.URL object
                    var URL = window.URL || window.webkitURL;

                    // Create ObjectURL
                    var imgURL = URL.createObjectURL(file);

                    // Set img src to ObjectURL
                    showPicture.src = imgURL;
                    document.getElementById("url"+event.target.id).value = imgURL;
                    // Revoke ObjectURL after imagehas loaded
                    showPicture.onload = function() {
                        URL.revokeObjectURL(imgURL);  
                    };
                }
                catch (e) {
                    try {
                        // Fallback if createObjectURL is not supported
                        var fileReader = new FileReader();
                        fileReader.onload = function (event) {
                            showPicture.src = event.target.result;
                            document.getElementById("url"+event.target.id).value = imgURL;
                        };
                        fileReader.readAsDataURL(file);
                    }
                    catch (e) {
                        // Display error message
                        var error = document.querySelector("#error");
                        if (error) {
                            error.innerHTML = "Neither createObjectURL or FileReader are supported";
                        }
                    }
                }
            }       
}