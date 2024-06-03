document.addEventListener('DOMContentLoaded', function () {
          var modal = document.getElementById("myModal");
          var btn = document.getElementById("openModal");
          var span = document.getElementsByClassName("close")[0];
      
          // Open modal
          btn.onclick = function () {
              modal.style.display = "block";
          };
      
          // Close modal
          span.onclick = function () {
              modal.style.display = "none";
          };
      
          // Close modal when clicking outside
          window.onclick = function (event) {
              if (event.target == modal) {
                  modal.style.display = "none";
              }
          };
      });
      