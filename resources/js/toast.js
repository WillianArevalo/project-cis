export function showToast(type, title, message) {
    let toasCount = 0;
    const toastContainer = $("#toast-container");
    const currentToastId = `toast-success-${toasCount++}`;
    const div = $(`<div id="${currentToastId}" role="alert"></div>`);
    div.addClass(
        "alert fixed right-10 top-10 z-[100] flex w-full max-w-sm animate-fade-left overflow-hidden rounded-lg bg-white shadow-md animate-duration-300 dark:bg-zinc-950"
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
    } else if (type === "info") {
        svg = `
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                <path d="M22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12Z" stroke="currentColor" stroke-width="1.5" />
                <path d="M12.2422 17V12C12.2422 11.5286 12.2422 11.2929 12.0957 11.1464C11.9493 11 11.7136 11 11.2422 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.992 8H12.001" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>`;
        color = "blue";
    }

    div.html(`
        <div class="flex w-12 items-center justify-center bg-${color}-500">
            ${svg}
        </div>
        <div class="-mx-3 px-4 py-2">
            <div class="mx-3 flex items-center justify-between">
                <div>
                    <span class="text-${color}-500 font-semibold">
                        ${title}
                    </span>
                    <p class="text-sm text-zinc-600 dark:text-zinc-200">
                        ${message}
                    </p>
                </div>

            </div>
        </div>
       `);
    toastContainer.append(div);

    setTimeout(() => {
        $(`#${currentToastId}`).remove();
    }, 3500);

    $(`button[data-dismiss-target="#${currentToastId}"]`).click(function () {
        const targetId = $(this).attr("data-dismiss-target");
        $(targetId).remove();
    });
}
