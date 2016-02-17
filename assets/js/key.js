function updateKey() {

    $('.key').empty();

    var keyArray = {
        "Note" : "note",
        "Downtime" : "downtime",
        "Warning" : "warning",
        "Critical" : "critical",
        "Down" : "down",
        "Unreachable" : "Unreachable",
        "Uninstantiated" : "uninstantiated",
        "Full" : "full",
        "Inuse" : "inuse",
        "Offline" : "offline",
        "Free" : "free",
        "ReadOnly" : "ReadOnly",
        "Ready" : "Ready",
        "Holding" : "Holding",
        "Replica" : "replica",
        "Production" : "Production",
        "Draining" : "Draining",
        "Decomissioned" : "Decomissioned",
        "Started" : "STARTED",
        "Relocating" : "RELOCATING",
        "Unassigned" : "UNASSIGNED",
        "Initializing" : "INITIALIZING",
    };

    $.each( keyArray, function( key, value ) {
        var node = $('.'+value);
        if (node[0]) {
            $('.key').append('<li class="key-item"><span class="node unknown '+value+'"></span>&nbsp;'+key+'</li>');
        }
    });
}
