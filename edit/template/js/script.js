document.addEventListener('DOMContentLoaded', function () {
    var removerButtons = document.querySelectorAll('.remover');

    removerButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            if (button.getAttribute('type') === 'checkbox' && !button.checked) {
                return true;
            }
            if (confirm(button.getAttribute('del_alert'))) {
                return true;
            } else {
                event.preventDefault();
                return false;
            }
        });
    });
});