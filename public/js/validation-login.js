document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#loginForm");
  if (!form) return;

  const statusBox = document.querySelector("#formStatus");

  const map = {
    email: { input: "#email", err: "#emailError" },
    password: { input: "#password", err: "#passwordError" },
  };

  function setStatus(type, msg) {
    if (!statusBox) return;
    if (!msg) {
      statusBox.className = "alert d-none";
      statusBox.textContent = "";
      return;
    }
    statusBox.className = `alert alert-${type}`;
    statusBox.textContent = msg;
  }

  function clearFeedback() {
    Object.keys(map).forEach((k) => {
      const input = document.querySelector(map[k].input);
      const err = document.querySelector(map[k].err);
      if (input) {
        input.classList.remove("is-invalid", "is-valid");
      }
      if (err) err.textContent = "";
    });
    setStatus(null, "");
  }

  function applyServerResult(data) {
    Object.keys(map).forEach((k) => {
      const input = document.querySelector(map[k].input);
      const err = document.querySelector(map[k].err);
      const msg = (data.errors && data.errors[k]) ? data.errors[k] : "";

      if (!input) return;
      if (msg) {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        if (err) err.textContent = msg;
      } else {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (err) err.textContent = "";
      }
    });

    if (data.errors && data.errors._global) {
      setStatus("danger", data.errors._global);
    }
  }

  async function callValidate() {
    const fd = new FormData(form);
    const res = await fetch("/api/validate/login", {
      method: "POST",
      body: fd,
      headers: { "X-Requested-With": "XMLHttpRequest" },
    });
    if (!res.ok) throw new Error("Erreur serveur lors de la validation.");
    return res.json();
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    clearFeedback();

    try {
      const data = await callValidate();
      applyServerResult(data);

      if (data.ok) {
        setStatus("success", "Validation OK ✅ Connexion en cours...");
        form.submit();
      } else {
        setStatus("danger", "Veuillez corriger les erreurs.");
      }
    } catch (err) {
      setStatus("warning", err.message || "Une erreur est survenue.");
    }
  });

  // Validation en temps réel sur blur
  Object.keys(map).forEach((k) => {
    const input = document.querySelector(map[k].input);
    if (input) {
      input.addEventListener("blur", async () => {
        try {
          const data = await callValidate();
          applyServerResult(data);
        } catch (_) {}
      });
    }
  });
});
