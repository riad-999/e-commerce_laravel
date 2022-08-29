<x-ui-elements.layout>
    <main class="mt-12 grid tablet:grid-cols-10 gap-4 mx-auto max-w-[1400px]">
        <section class="tablet:col-span-3 desk:col-span-2
        order-last tablet:order-first tablet:border-r border-t 
        tablet:border-t-0 border-solid border-border pl-4 pt-4 tablet:pt-0">
            {{$side}}
        </section>
        <section class="tablet:col-span-7 desk:col-span-8 p-4">
            {{$slot}}
        </section>
    </main>
</x-ui-elements.layout>