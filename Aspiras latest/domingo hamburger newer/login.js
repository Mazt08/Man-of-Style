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

    // Fake authentication 
    if (email === "user@gmail.com" && password === "12341234") {
      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-success mt-2";
      alertDiv.textContent = "Login successful! Redirecting...";
      form.parentNode.insertBefore(alertDiv, form);

      // Redirect after 1.5 seconds
      setTimeout(() => {
        window.location.href = "Logged In/log index.html";
      }, 1500);
    } 
    else if (email === "admin@gmail.com" && password === "admin123") {
      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-success mt-2";
      alertDiv.textContent = "Login successful! Redirecting...";
      form.parentNode.insertBefore(alertDiv, form);

      // Redirect after 1.5 seconds
      setTimeout(() => {
        window.location.href = "Admin/admin.html";
      }, 1500);
    } 
    else if (email === "product@gmail.com" && password === "product123") {
      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-success mt-2";
      alertDiv.textContent = "Login successful! Redirecting...";
      form.parentNode.insertBefore(alertDiv, form);

      // Redirect after 1.5 seconds
      setTimeout(() => {
        window.location.href = "Admin/p-product.html";
      }, 1500);
    } 
    else if (email === "management@gmail.com" && password === "management123") {
      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-success mt-2";
      alertDiv.textContent = "Login successful! Redirecting...";
      form.parentNode.insertBefore(alertDiv, form);

      // Redirect after 1.5 seconds
      setTimeout(() => {
        window.location.href = "Admin/m-management.html";
      }, 1500);
    } 
    else if (email === "auser@gmail.com" && password === "user123") {
      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-success mt-2";
      alertDiv.textContent = "Login successful! Redirecting...";
      form.parentNode.insertBefore(alertDiv, form);

      // Redirect after 1.5 seconds
      setTimeout(() => {
        window.location.href = "Admin/u-user.html";
      }, 1500);
    } 
    else if (email === "report@gmail.com" && password === "report123") {
      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-success mt-2";
      alertDiv.textContent = "Login successful! Redirecting...";
      form.parentNode.insertBefore(alertDiv, form);

      // Redirect after 1.5 seconds
      setTimeout(() => {
        window.location.href = "Admin/r-report.html";
      }, 1500);
    } 
    else {
      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-danger mt-2";
      alertDiv.textContent = "Invalid email or password.";
      form.parentNode.insertBefore(alertDiv, form);
    }
  });
});

document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("inputPassword");
    const icon = this.querySelector("i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";        // show password
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";    // hide password
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});
