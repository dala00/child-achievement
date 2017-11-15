$(function() {

    let statuses = {};

    $('[data-action]').click(function() {
        const action = $(this).data('action');
        statuses[action] = !statuses[action];
        axios.put('/home/toggle', {
            action: action,
            status: statuses[action],
        });
        render();
    })

    function render() {
        for (let action in statuses) {
            const panel = $(`[data-action=${action}] .panel`);
            if (statuses[action]) {
                panel.addClass('panel-primary');
            } else {
                panel.removeClass('panel-primary');
            }
        }
    }

    $('[data-action]').each(function() {
        const action = $(this).data('action');
        const enabled = $(this).data('enabled');
        statuses[action] = enabled;
    })

    render();
})
