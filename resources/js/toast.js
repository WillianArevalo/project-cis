export function showToast(type, title, message) {
    let toasCount = 0;
    const toastContainer = $("#toast-container");
    const currentToastId = `toast-success-${toasCount++}`;
    const div = $(`<div id="${currentToastId}" role="alert"></div>`);
    div.addClass(
        "alert fixed top-10 z-[100] flex w-full max-w-sm animate-fade-left overflow-hidden rounded-lg bg-white shadow-md animate-duration-300 dark:bg-zinc-950 sm:right-10"
    );

    let svg = "";
    let color = "green";
    if (type === "success") {
        svg = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                <path d="M22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12Z" stroke="currentColor" stroke-width="1.5" />
                <path d="M8 12.5L10.5 15L16 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>`;
    } else if (type === "error") {
        svg = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                <path d="M11.992 15H12.001" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M12 12L12 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>`;
        color = "red";
    } else if (type === "warning") {
        svg = `
            <svg class="size-6 text-white" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" /></svg>`;
        color = "yellow";
    }

    div.html(`
        <div class="flex w-12 items-center justify-center bg-${color}-500">
            ${svg}
        </div>
        <div class="-mx-3 px-4 py-2 flex items-center justify-between w-full">
            <div class="mx-3">
                <div>
                    <span class="text-${color}-500 font-semibold">
                        ${title}
                    </span>
                    <p class="text-sm text-zinc-600 dark:text-zinc-200">
                        ${message}
                    </p>
                </div>
            </div>
             <button type="button"
                class="ms-auto me-2 bg-white text-zinc-400 hover:text-zinc-900 rounded-xl focus:ring-2 focus:ring-zinc-300  hover:bg-zinc-100 inline-flex items-center justify-center h-8 min-w-8 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800 dark:hover:text-zinc-100"
                data-dismiss-target="#${currentToastId}" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
              </button>
        </div>`);
    toastContainer.append(div);

    $(`button[data-dismiss-target="#${currentToastId}"]`).click(function () {
        const targetId = $(this).attr("data-dismiss-target");
        $(targetId).remove();
    });
}
