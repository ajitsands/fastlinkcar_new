let shortcutMap = {};

fetch("get_shortcuts.php")
    .then(res => res.json())
    .then(data => {
        shortcutMap = data;
    });

document.addEventListener("keydown", function (e) {
    let key = "";

    if (e.ctrlKey) key += "Ctrl+";
    if (e.altKey) key += "Alt+";
    if (e.shiftKey) key += "Shift+";

    key += e.key.toUpperCase();

    for (let action in shortcutMap) {
        if (shortcutMap[action] === key) {
            e.preventDefault();
            executeAction(action);
        }
    }
});

function executeAction(action) {
    switch (action) {
        case "open_dashboard":
            window.location.href = "dashboard.php";
            break;

        case "open_sales":
            window.location.href = "sales.php";
            break;

        case "open_purchase":
            window.location.href = "purchase.php";
            break;

        case "open_accounts":
            window.location.href = "accounts.php";
            break;

        case "new_invoice":
            window.location.href = "invoice_new.php";
            break;

        case "save_record":
            let saveBtn = document.querySelector(".btn-save");
            if (saveBtn) saveBtn.click();
            break;

        case "search":
            let searchBox = document.querySelector(".search-box");
            if (searchBox) searchBox.focus();
            break;

        case "logout":
            window.location.href = "logout.php";
            break;
    }
}
