// Filter tables by search input id= filterInput / table id = tableToFilter
const filterInput = document.getElementById("filterInput");
if (filterInput != null) {
    filterInput.addEventListener("keyup", function () {
        let keyword = this.value;
        let tableToFilter = document.getElementById("tableToFilter");
        let allRows = tableToFilter.getElementsByTagName('tr');
        for (let i = 0; i < allRows.length; i++) {

            let all_col = allRows[i].getElementsByTagName('td');

            for (let j = 0; j < all_col.length; j++) {

                if (all_col[j]) {
                    let col_val = all_col[j].innerText || all_col[j].textContent;
                    col_val = col_val.toUpperCase();
                    if (col_val.toLowerCase().indexOf(keyword.toLowerCase()) > -1) {
                        allRows[i].style.display = "";
                        break;
                    } else {
                        allRows[i].style.display = "none";
                    }
                }
            }

        }
    });
}

/* Sorting tables class="table-sortable" - table to sort/ column to sort / bool for asc or desc */
/*
function sortTableByColumn(table, column, asc = true) {
    const dirModifier = asc ? 1 : -1;
    const tBody = table.tBodies[0];
    const rows = Array.from(tBody.querySelectorAll("tr"));

    // Sort each row
    const sortedRows = rows.sort((a, b) => {
        const colum = column + 1;
        const aColText = a.querySelector('td:nth-child(' + colum + ')').textContent.trim();
        const bColText = b.querySelector('td:nth-child(' + colum + ')').textContent.trim();

        return aColText > bColText ? (1 * dirModifier) : (-1 * dirModifier);
    });

    // Remove all existing tr from the table
    while (tBody.firstChild) {
        tBody.removeChild(tBody.firstChild);
    }

    // Re-add the newly sorted rows
    tBody.append(...sortedRows);

    // Remember how the column is sorted
    table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
    table.querySelector("th:nth-child(" + (column + 1) + ")").classList.toggle("th-sort-asc", asc);
    table.querySelector("th:nth-child(" + (column + 1) + ")").classList.toggle("th-sort-desc", !asc);
}

document.querySelectorAll(".tableSortable th").forEach(headerCell => {

    headerCell.addEventListener("click", () => {

        const tableElement = headerCell.parentElement.parentElement.parentElement;
        const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell);
        const currentIsAscending = headerCell.classList.contains("th-sort-asc");

        sortTableByColumn(tableElement, headerIndex, !currentIsAscending);

    });

});
*/