(function () {
    function initPassShowHide() {
        const eyeOpeners = document.querySelectorAll(".eye-opener");
        eyeOpeners.forEach(function (opener) {
            opener.addEventListener("click", function () {
                let input = null;
                if (opener.id && opener.id.endsWith("_opener")) {
                    const inputId = opener.id.replace("_opener", "");
                    input = document.getElementById(inputId);
                }
                if (!input) {
                    const parent = opener.closest(".form-group") || opener.parentElement;
                    input = parent ? parent.querySelector("input") : null;
                }

                if (input) {
                    const icon = opener.querySelector("i");
                    if (input.type === "password") {
                        input.type = "text";
                        if (icon) {
                            if (icon.classList.contains("fa-eye-slash")) {
                                icon.classList.remove("fa-eye-slash");
                                icon.classList.add("fa-eye");
                            } else {
                                icon.classList.remove("fa-eye");
                                icon.classList.add("fa-eye-slash");
                            }
                        }
                    } else {
                        input.type = "password";
                        if (icon) {
                            if (icon.classList.contains("fa-eye")) {
                                icon.classList.remove("fa-eye");
                                icon.classList.add("fa-eye-slash");
                            } else {
                                icon.classList.remove("fa-eye-slash");
                                icon.classList.add("fa-eye");
                            }
                        }
                    }
                }
            });
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initPassShowHide);
    } else {
        initPassShowHide();
    }
})();
