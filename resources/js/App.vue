<template>
    <div class="w-96 m-auto">
        <nav class="border border-black bg-white p-4 flex gap-2">
            <RouterLink to="/" activeClass="border-b border-neutral-500">Home</RouterLink>
            <RouterLink to="/about" activeClass="border-b border-neutral-500">About</RouterLink>
        </nav>
        <main>
            <RouterView />
        </main>
    </div>
</template>