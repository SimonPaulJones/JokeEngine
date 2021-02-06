window.onload = function() {

  // Init VueJS
  var app = new Vue({
    el: '#app',
    data: {
      jokes: '',
      s: ''
    }
  })

  // Insert or remove the 'S' depending on the qty select
  var sel = document.querySelector('#n')
  var api = document.querySelector('#api')
  sel.addEventListener("change", function() {
    if (sel.value == 1) {
      app.s = ''
    } else {
      app.s = 's'
    }
  });

  // Tell the go button to get the jokes and feed to Vue
  var but = document.querySelector('#go')
  but.addEventListener("click", function() {
    app.jokes = [{
      "text": "Testing for Laughs ..."
    }];
    var xmlhttp = new XMLHttpRequest();
    var url = "getjoke.php?api=" + api.value + "&no=" + sel.value;
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var myArr = JSON.parse(this.responseText);
        getJokes(myArr);
      }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
    function getJokes(arr) {
      app.jokes = arr
    }
  })
}
