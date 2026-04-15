@php
    $h = $home ?? [];
    $proc = data_get($h, 'processus', []);
@endphp

<section class="bg-slate-50/70 py-16 sm:py-20">
    <div class="mx-auto w-[95%] px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-soft">
            <div class="border-b border-slate-100 px-5 py-8 sm:px-8 sm:py-10">
                <div class="min-w-0">
                    <h2 class="text-3xl font-extrabold leading-tight text-brand-dark sm:text-4xl lg:text-5xl">
                        <span class="text-brand-blue">{{ data_get($proc, 'title_accent') }}</span>{{ filled(data_get($proc, 'title_rest')) ? ' ' : '' }}{{ data_get($proc, 'title_rest') }}
                    </h2>
                    <p class="mt-3 max-w-3xl text-base text-slate-600 sm:text-lg">{{ data_get($proc, 'intro') }}</p>
                </div>
            </div>

            <div class="relative px-5 py-6 sm:px-8 sm:py-8">
                <div class="pointer-events-none absolute left-0 right-0 top-[2.25rem] hidden h-px bg-gradient-to-r from-transparent via-brand-blue/35 to-transparent lg:block" aria-hidden="true"></div>
                <ol class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                    @foreach (data_get($proc, 'steps', []) as $step)
                        @php
                            $isOdd = ($loop->iteration % 2) === 1;
                            $numClass = $isOdd
                                ? 'inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-blue text-sm font-black text-white shadow-md shadow-brand-blue/25 lg:mx-auto lg:mb-4'
                                : 'inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-dark text-sm font-black text-white shadow-md lg:mx-auto lg:mb-4';
                            $liClass = 'relative rounded-xl border border-slate-100 bg-slate-50/60 p-5 lg:border-slate-100/80 lg:bg-white lg:p-6 lg:text-center lg:shadow-sm';
                            if (!empty($step['span'])) {
                                $liClass .= ' sm:col-span-2 lg:col-span-1';
                            }
                        @endphp
                        <li class="{{ $liClass }}">
                            <div class="flex items-start gap-4 lg:flex-col lg:items-center">
                                <span class="{{ $numClass }}">{{ data_get($step, 'num') }}</span>
                                <div class="min-w-0">
                                    <h4 class="break-words text-base font-extrabold text-brand-dark sm:text-lg lg:text-center">{{ data_get($step, 'title') }}</h4>
                                    <p class="mt-2 text-sm leading-relaxed text-slate-600 lg:text-center">{{ data_get($step, 'text') }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>

