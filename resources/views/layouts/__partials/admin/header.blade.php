 @props(['title', 'icon'])

 <div class="flex items-center gap-2">
     <x-icon icon="{{ $icon }}" class="size-7 text-zinc-800 dark:text-white sm:size-8 md:size-10" />
     <h1 class="text-xl font-bold text-zinc-800 dark:text-white sm:text-2xl md:text-3xl lg:text-4xl">
         {{ $title }}
     </h1>
 </div>
