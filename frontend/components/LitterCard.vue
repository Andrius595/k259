<template>

    <!-- card -->
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
      <!-- image -->
      <div class="flex justify-center">
        <slot name="image"></slot>
      </div>
      <!-- title -->
      <div class="mt-4">
        <slot name="title"></slot>
      </div>
      <!-- description -->
      <div class="mt-4">
        <slot name="description"></slot>
      </div>
        <!-- button --> 
        <div class="mt-4">
        <slot name="button"></slot>
        </div>  
        </div>

</template>