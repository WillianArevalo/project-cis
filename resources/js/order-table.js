import DataTable from "datatables.net-dt";

$(document).ready(function () {
    const defaultTableOptions = {
        paging: false,
        info: false,
        emptyTable: "No hay datos disponibles",
        language: {
            emptyTable: "No hay datos disponibles",
        },
    };

    const tables = [
        { id: "#tableScholarships", searchInput: "#inputSearchScholarships" },
        { id: "#tableProjects", searchInput: "#inputSearchProjects" },
        { id: "#tableCommunities", searchInput: "#inputSearchCommunities" },
        { id: "#tableUsers", searchInput: "#inputSearchUsers" },
        { id: "#tableReports", searchInput: "#inputSearchReports" },
    ];

    const initializedTables = {};
    tables.forEach(({ id, searchInput }) => {
        const table = new DataTable(id, defaultTableOptions);
        initializedTables[id] = table;
        if (searchInput) {
            $(searchInput).on("keyup", function () {
                table.search($(this).val()).draw();
            });
        }
    });

    const filters = [
        {
            tableId: "#tableProduct",
            filterInput: "input[name='filter-status']",
        },
    ];

    filters.forEach(({ tableId, filterInput }) => {
        $(filterInput).on("change", function () {
            const value = $(this).val();
            initializedTables[tableId].search(value).draw();
        });
    });

    filters.forEach(({ tableId, filterInput }) => {
        $(filterInput).on("Changed", function () {
            const value = $(this).val();
            initializedTables[tableId].search(value).draw();
        });
    });
});
