//Dashboard initialization method. Is called when page loads. Requests all of the users notes from the server
function init () {
  var a = $.ajax({
    url: "core/getNotes.php",
    type: "POST",
    dataType: "json",
  });
  a.done(loadNotes);
}

//Event handler that gets called when the server returns all of a users notes. Loads them into the webpage
function loadNotes (data) {
  for (var n in data) {
    var i = data[n];
    if (data.hasOwnProperty(n)) {
      var note = $('<div class="note" id="'+i["id"]+'"><p>'+i["text"]+'</p><div class="d">x</div></div>');
      note.css({
        top: i["y"] + "px",
        left: i["x"] + "px"
      }).show();
      addToPage(note);
    }    
  }
}

//Sets a click event on the plus button. 
$('#plus').on('click', function (e) {
  var text = $('#textarea').val();
  if (text) {
    window.text = text;
    var a = $.ajax({
      url: "core/plus.php",
      type: "POST",
      dataType: "text",
      data: "text=" + text
    });
    a.done(plusSuccess);
  }
});

//Event handler that sends note data to database
function createNote(data) {
  alert("test");
  
}

//Event handler that gets called when a new note is put into the database. Creates a note on the webpage
function plusSuccess(data) {
	var note = $('<div class="note" id="'+data+'"><p>'+window.text+'</p><div class="d">x</div></div>');
  addToPage(note);
}

//Event handler that gets called when the user stops dragging a note. Tells the server the new note coordinates
function drop (e) {
  var note = $(e.target);
  var main = $("#main");
  var id = note.attr('id');
  var x = note.offset().left - main.offset().left;
  var y = note.offset().top - main.offset().top;
  var params = "id="+id+"&x="+x+"&y="+y;
  $.ajax({
    url: "core/update.php",
    type: "POST",
    dataType: "text",
    data: params
  });
}

//Event handler that gets called when the x button is pressed on a note. Deletes the note
function del (e) {
  var parent = $(e.target).parent();
  var id = parent.attr('id');
  parent.remove();
  $.ajax({
    url: "core/delete.php",
    type: "POST",
    dataType: "text",
    data: "id=" + id
  });
}

//Adds the note div to the page
function addToPage(note) {
  $('#main').append(note);
  $('.d', note).on('click', del);
  note.draggable({ containment: "#main", scroll: false, stop: drop });
}

window.onload = init;
