$(document).ready(function () {
    const $dateInput = $("#date-input");
    const $calendar = $("#calendar");
    const months = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
    ];

    let currentDate = new Date();
    const today = new Date();

    $dateInput.click(function () {
        $calendar.toggle();
        buildCalendar(currentDate);
    });

    $(document).click(function (e) {
        if (
            !$(e.target).closest(
                "#calendar, #date-input, .prev-month, .next-month"
            ).length
        ) {
            $calendar.hide();
        }
    });

    function buildCalendar(date) {
        $calendar.empty();
        const month = date.getMonth();
        const year = date.getFullYear();
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        const calendarHeader = $(`
            <div class="flex justify-between gap-2 items-center mb-4 dark:bg-zinc-950">
                <button class="prev-month text-white p-2 rounded-xl bg-zinc-500 hover:bg-zinc-600 dark:bg-zinc-900 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5 text-current"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                </button>
                <div class="flex items-center space-x-2">
                    <select id="month-select" class="text-zinc-800 p-2 rounded-xl border border-zinc-400 focus:outline-none focus:border-zinc-600 focus:ring-0 text-xs sm:text-sm dark:bg-zinc-950 dark:text-zinc-300  dark:focus:border-zinc-500 dark:border-zinc-800 dark:focus:ring-0">
                        ${months
                            .map(
                                (m, i) =>
                                    `<option value="${i}" ${
                                        i === month ? "selected" : ""
                                    } class="hover:bg-zinc-100">${m}</option>`
                            )
                            .join("")}
                    </select>
                    <input type="number" id="year-input" class="text-zinc-800 p-2 rounded-xl border border-zinc-400 focus:outline-none focus:border-zinc-600 focus:ring-0 text-xs sm:text-sm dark:bg-zinc-950 dark:text-zinc-300  dark:focus:border-zinc-500 dark:border-zinc-800 dark:focus:ring-0 w-20" value="${year}">
                </div>
                <button class="next-month text-white p-2 bg-zinc-500 hover:bg-zinc-600 rounded-xl dark:bg-zinc-900 dark:hover:bg-zinc-800">
                    <svg class="w-5 h-5 text-current"   xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                </button>
            </div>
        `);
        $calendar.append(calendarHeader);

        const calendarTable = $(`
            <table class="table-auto w-full text-center">
                <thead>
                    <tr class="text-secondary text-sm dark:text-zinc-400 text-zinc-800">
                        <th class="p-2">Dom</th>
                        <th class="p-2">Lun</th>
                        <th class="p-2">Mar</th>
                        <th class="p-2">Mié</th>
                        <th class="p-2">Jue</th>
                        <th class="p-2">Vie</th>
                        <th class="p-2">Sáb</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        `);
        $calendar.append(calendarTable);

        const $calendarBody = calendarTable.find("tbody");
        let row = $("<tr></tr>");

        for (let i = 0; i < firstDay; i++) {
            row.append('<td class="p-2"></td>');
        }

        for (let day = 1; day <= lastDate; day++) {
            if ((firstDay + day - 1) % 7 === 0 && day !== 1) {
                $calendarBody.append(row);
                row = $("<tr></tr>");
            }

            const isToday =
                day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear();

            const cellClass = isToday
                ? "dark:bg-blue-800 dark:text-white bg-blue-500 hover:bg-blue-600 dark:hover:bg-blue-900 text-white"
                : "dark:hover:bg-zinc-900 hover:bg-zinc-200";

            const cell = $(
                `<td class="p-2 text-xs sm:text-sm cursor-pointer rounded-xl dark:text-zinc-400 text-zinc-800 ${cellClass}" data-day="${day}" data-month="${
                    month + 1
                }" data-year="${year}">${day}</td>`
            );
            cell.click(function () {
                $dateInput.val(`${year}-${month + 1}-${day}`);
                $calendar.hide();
            });
            row.append(cell);
        }

        $calendarBody.append(row);

        $(".prev-month").click(function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            buildCalendar(currentDate);
        });

        $(".next-month").click(function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            buildCalendar(currentDate);
        });

        $("#month-select").change(function () {
            currentDate.setMonth(parseInt(this.value));
            buildCalendar(currentDate);
        });

        $("#year-input").change(function () {
            currentDate.setFullYear(parseInt(this.value));
            buildCalendar(currentDate);
        });
    }
});
