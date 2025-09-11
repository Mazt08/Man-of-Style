document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("contact-form");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      form.querySelector("button").disabled = true;
      form.querySelector("button").textContent = "Sending...";

      setTimeout(() => {
        form.reset();
        form.querySelector("button").disabled = false;
        form.querySelector("button").textContent = "Send Message";
        alert(
          "Thank you for contacting Man of Style! We will get back to you soon."
        );
      }, 1200);
    });
  }
});

//User Icon Logout
function logoutUser() {
    alert("You're now getting redirected to the User Page");
}