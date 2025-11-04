@php

    $listContainer = 'flex flex-col';
    $listArrow = 'flex flex-row gap-2 align-middle text-white';
    $listSmallInfo = 'pl-8 text-sm italic text-gray-400 w-8/12';
    $listLine = $horizontalLine;

@endphp

<div>
    <div class="mr-36 ml-36">
        <div class="inline-flex items-center justify-center w-full mt-10">
            <hr class="{{ $hrView }} mt-10" />
            <div class="absolute px-4 -translate-x-1/2 bg-zinc-900 left-1/2 dark:bg-zinc-900">
                {!! $lineMotif !!}
            </div>
        </div>
    </div>    
    <div class="{{ $paragraph_1 }} mt-10 pl-5 pr-5">
        It is a very simple, and easy to work with. Built using a standard Laravel/Livewire framework and MySQL. The
        application focuses on the whole lifecycle of the incident/case management process, from the point when the
        incidence/case is raised, the handling of it which involves customer, team and personnel interaction, to its
        resolution and closure. The key idea is transparency, visibility and efficiency in moving the incidence/case
        from one stage
        to another preventing the risk of being missed or left stagnant.
    </div>
    <div class="mr-36 ml-36">
        <div class="inline-flex items-center justify-center w-full mt-5">
            <hr class="{{ $hrView }} mt-10" />
            <div class="absolute px-4 -translate-x-1/2 bg-zinc-900 left-1/2 dark:bg-zinc-900">
                {!! $lineMotif !!}
            </div>
        </div>
    </div>
    <div class="{{ $paragraph_3 }} ml-5">
        Some of its main features are ...
        <div class="flex flex-col gap-2">
            <ul class="{{ $list }} mt-4">
                {{-- Status Dashboard --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>Status Dashboard</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. provide a summary of all incidences/cases status currently in progress
                        </div>
                    </div>
                </li>
                {{-- Incidence/Case List --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>Incidence/Case List</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. with intuitive tabs that provide easy access to incidences/cases lists based on their
                            status
                            with search facility
                        </div>
                    </div>
                </li>
                {{-- Incidence/Case Profile --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>Incidence/Case Profile</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. provide all the required information and actions of the selected incidence/case
                            together with facilities to move it forward, for example, progress action,
                            progress log timeline, resolution etc.,
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="{{ $list }} mt-4">
                {{-- Incidence/Case Calendar --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>Incidence/Case Event Calendar</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. provides a calendar view of events relating
                            to outstanding incidences/cases, for example, respond-by,
                            breach, scheduled visits etc.,
                        </div>
                    </div>
                </li>
                {{-- Customer Site List --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>Customer Site List</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. provides the list of customer sites, with search facility and a
                            quick view of a type of a site (Main or Child). If a site
                            is a child, its parent (Main) will be specified.
                        </div>
                    </div>
                </li>
                {{-- Customer Site Profile --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>Customer Site Profile</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. provide customer site profile information, which
                            include, amongst others, list of assets, associated
                            service level agreement, contacts, site document folder,
                            and a create incidence/case facility etc.,
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="{{ $list }} mt-4">
                {{-- Product & Supplier --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>Product & Supplier</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. every site can be associated to products and
                            Products can be associated to suppliers. Therefore,
                            the App provides the facility to create list of products
                            and suppliers. Products linked to a site are called
                            assets.
                        </div>
                    </div>
                </li>
                {{-- Service Level Agreement --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>Service Level Agreement</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. this feature make it easy to apply a Service Level Agreement which
                            forms a contract of service to customer site. Create a template of SLA
                            then apply it to more than one sites with customisation. A site can have
                            more than one SLA.
                        </div>
                    </div>
                </li>
                {{-- User Management --}}
                <li class="{{ $list_item }}">
                    <div class="{{ $listContainer }}">
                        <div class="{{ $listArrow }}">
                            {!! $arrowRight !!}
                            <span>User, Role & Permission Management</span>
                        </div>
                        <div class="{{ $listSmallInfo }}">
                            <hr class="{{ $listLine }}" />
                            .. it provides user and role management. Role can be created and
                            associated with users. Configuration of permission will depend
                            on the roles, hence users based on their roles will have access
                            to certain pages that are specified by the roles.
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
