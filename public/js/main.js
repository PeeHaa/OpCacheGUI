(function() {
    // draw graphs
    var graphs = document.querySelectorAll('canvas.graph');
    for (var i = 0, l = graphs.length; i < l; i++) {
        var ctx = graphs[i].getContext('2d');
        new Chart(ctx).Pie(JSON.parse(graphs[i].getAttribute('data-data')), {segmentShowStroke: false});
    }

    // reset cache
    var resetForm = document.getElementById('reset');
    if (resetForm) {
        resetForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var confirmationBox = document.createElement('div'),
                confirmationQuestion = document.createElement('p'),
                confirmationYes = document.createElement('button'),
                confirmationNo = document.createElement('button');

            confirmationBox.setAttribute('class', 'confirmation');
            confirmationQuestion.appendChild(document.createTextNode(resetForm.getAttribute('data-confirmation')));
            confirmationNo.appendChild(document.createTextNode(resetForm.getAttribute('data-no')));
            confirmationYes.appendChild(document.createTextNode(resetForm.getAttribute('data-yes')));

            confirmationBox.appendChild(confirmationQuestion);
            confirmationBox.appendChild(confirmationNo);
            confirmationBox.appendChild(confirmationYes);

            resetForm.parentNode.parentNode.appendChild(confirmationBox);
            resetForm.querySelector('input[type=submit]').setAttribute('disabled', 'disabled');

            confirmationNo.addEventListener('click', function(e) {
                confirmationBox.parentNode.removeChild(confirmationBox);
                resetForm.querySelector('input[type=submit]').removeAttribute('disabled');
            });

            confirmationYes.addEventListener('click', function(e) {
                confirmationYes.setAttribute('disabled', 'disabled');
                confirmationNo.setAttribute('disabled', 'disabled');

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState < 4 || xhr.status !== 200) {
                        return;
                    }

                    if (xhr.readyState === 4) {
                        var data = JSON.parse(xhr.responseText);

                        if (typeof data.result === 'undefined' || data.result !== 'success') {
                            confirmationYes.removeAttribute('disabled');
                            confirmationNo.removeAttribute('disabled');
                         } else {
                            location.reload(true);
                        }
                    }
                }.bind(this);

                xhr.open(resetForm.method, resetForm.action, true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('csrfToken=' + resetForm.querySelector('input[type=hidden]').value);
            });
        });
    }
}());
