document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const container = document.querySelector(".login-container");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    // Remove any previous alerts
    const oldAlert = container.querySelector(".alert");
    if (oldAlert) oldAlert.remove();

    const email = document.getElementById("inputEmail").value.trim();
    const password = document.getElementById("inputPassword").value.trim();

    if (!email || !password) {
      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-danger mt-2";
      alertDiv.textContent = "Please enter both email and password.";
      form.parentNode.insertBefore(alertDiv, form);
      return;
    }

    // TODO: Add your authentication logic here
    const alertDiv = document.createElement("div");
    alertDiv.className = "alert alert-success mt-2";
    alertDiv.textContent = "Login submitted!";
    form.parentNode.insertBefore(alertDiv, form);
  });
});
