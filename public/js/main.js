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
        $(resetForm).on('submit', function(e) {
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


    // invalidate script
    var cachedTable = document.getElementById('cached');
    if (cachedTable) {
        $(cachedTable).on('submit', function(e) {
            e.preventDefault();
            var invalidateForm = $(e.target).closestByTagName('form');

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState < 4 || xhr.status !== 200) {
                    return;
                }

                if (xhr.readyState === 4) {
                    var data = JSON.parse(xhr.responseText);

                    if (typeof data.result === 'undefined' || data.result !== 'success') {
                        // I should really handle the error here
                    } else {
                        $($(invalidateForm).closestByTagName('tr')).fadeOut(function() {
                            $(invalidateForm).closestByTagName('tr').parentNode.removeChild($(invalidateForm).closestByTagName('tr'));
                        }, 20);
                    }
                }
            }.bind(this);

            xhr.open(invalidateForm.method, invalidateForm.action, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('csrfToken=' + invalidateForm.querySelector('input[name="csrfToken"]').value + '&key=' + encodeURIComponent(invalidateForm.querySelector('input[name="key"]').value));
        });
    }

    // toggle display cached scripts
    var cachedTable = document.getElementById('cached');
    if (cachedTable) {
        $(cachedTable).on('click', function(e) {
            var td = $(e.target).closestByTagName('td');

            if (!td || !$(td).hasClass('directory')) {
                return;
            }

            if ($(td).hasClass('active')) {
                $(td).removeClass('active');
                td.querySelector('img').src = 'style/toggle-expand.png';
                td.querySelector('img').setAttribute('alt', '+');
                var rows = document.querySelectorAll('.script');
                for (var i = 0, l = rows.length; i < l; i++) {
                    if (rows[i].getAttribute('data-directoryid') != td.getAttribute('data-directoryid')) {
                        continue;
                    }

                    $(rows[i]).removeClass('active');
                }
            } else {
                $(td).addClass('active');
                td.querySelector('img').src = 'style/toggle-collapse.png';
                td.querySelector('img').setAttribute('alt', '-');
                var rows = document.querySelectorAll('.script');
                for (var i = 0, l = rows.length; i < l; i++) {
                    if (rows[i].getAttribute('data-directoryid') != td.getAttribute('data-directoryid')) {
                        continue;
                    }

                    $(rows[i]).addClass('active');
                }
            }
        });
    }
}());
