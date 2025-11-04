@php
    $upload = Config::get('steps.form.fileInput');
    $table = Config::get('steps.tableClasses.table');
    $thead = Config::get('steps.tableClasses.thead');
    $tbody = Config::get('steps.tableClasses.tbody');
    $td = ''; //Config::get('steps.tableClasses.td');
    $th = ''; //Config::get('steps.tableClasses.th');
    $stdBg = Config::get('steps.standardBgColor');
    $text = Config::get('steps.standardTextColor');
    $thead = str_replace('uppercase','',$thead);
@endphp
<div class="overflow-auto dark:{{ $stdBg }}">
    <form action="{{ route('importAssets',[$customer]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-modal-steps>
            <x-slot name="title">
                Upload Excel File for Export to Assets
            </x-slot>
            <x-slot name="modalContent">
                @if (session('success'))
                    <p style="color: green;">{{ session('success') }}</p>
                    <p>File Path: {{ session('file') }}</p>
                @endif
                <input type="file" class="{{ $upload }}" name="assetFile">
            </x-slot>
            <x-slot name="buttonActionName">
                Upload
            </x-slot>
        </x-modal-steps>
    </form>
    <div class="overflow-auto dark:{{ $stdBg }} px-6 py-5">
        <p class="dark:{{ $text }} py-5">
            The column names and data types of the selected excel file must match the specifications below
        </p>
        <table class="{{ $table }}">
            <thead class="{{ $thead }}">
                <tr>
                    <th class="{{ $th }}">short_description</th>
                    <th class="{{ $th }}">asset_number</th>
                    <th class="{{ $th }}">product_id</th>
                    <th class="{{ $th }}">supplier_id</th>
                    <th class="{{ $th }}">buy_price</th>
                    <th class="{{ $th }}">sell_price</th>
                    <th class="{{ $th }}">notes</th>
                    <th class="{{ $th }}">license_number</th>
                    <th class="{{ $th }}">location</th>
                    <th class="{{ $th }}">technical_specification</th>
                    <th class="{{ $th }}">mac_address</th>
                    <th class="{{ $th }}">ip_address</th>
                </tr>
            </thead>
            <tbody class="{{ $tbody }}">
                <tr>
                    <td class="{{ $td }}">string/text</td>
                    <td class="{{ $td }}">string/text</td>
                    <td class="{{ $td }}">int (id)</td>
                    <td class="{{ $td }}">int (id)</td>
                    <td class="{{ $td }}">decimal</td>
                    <td class="{{ $td }}">decimal</td>
                    <td class="{{ $td }}">string/text/null</td>
                    <td class="{{ $td }}">string/text/null</td>
                    <td class="{{ $td }}">string/text/null</td>
                    <td class="{{ $td }}">string/text/null</td>
                    <td class="{{ $td }}">string/text/null</td>
                    <td class="{{ $td }}">string/text/null</td>
                </tr>
            </tbody>            
        </table>
    </div>
</div>

