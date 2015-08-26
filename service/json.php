<html>

<head>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

<script language="javascript">

// This just displays the first parameter passed to it
// in an alert.
function show(json) {
   alert(json);
}

function run() {
   $.getJSON(
 "/test.php", // The server URL 
    { id: 567 }, // Data you want to pass to the server.
   show // The function to call on completion.
    );
}

// We'll run the AJAX query when the page loads.
window.onload=run;

</script>

</head>

<body>

JSON Test Page.

</body>

</html>
