(function() {
    var graphs = document.querySelectorAll('canvas.graph');
    for (var i = 0, l = graphs.length; i < l; i++) {
        var ctx = graphs[i].getContext('2d');
        new Chart(ctx).Pie(JSON.parse(graphs[i].getAttribute('data-data')), {segmentShowStroke: false});
    }
}());
