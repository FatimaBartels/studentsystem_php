function loadContent(type, id) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `load-content.php?type=${type}&id=${id}`, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      document.getElementById("main-content").innerHTML = xhr.responseText;
    } else {
      document.getElementById("main-content").innerHTML =
        "<p>Fout bij laden van gegevens.</p>";
    }
  };
  xhr.send();
}
