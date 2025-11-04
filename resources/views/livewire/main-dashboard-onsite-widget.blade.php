@php

    $textStyle = Config::get('steps.widget.text');
    $titleStyle = Config::get('steps.widget.title');
    $headerStyle = Config::get('steps.widget.header');
    $gridGroupSpan5 = Config::get('steps.widget.grid');
    $gridGroupSpan5_container = Config::get('steps.widget.container');
    $gridGroupSpan5_content = Config::get('steps.widget.content');
    $whiteBox = Config::get('span.whiteBox');
    $displayStyleA = true;
    $moniker = Config::get('steps.ticket');

@endphp

<div name="gridGroupSpan5" class="{{ $gridGroupSpan5 }}">

    <div name="gridGroupSpan5_container" class="{{ $gridGroupSpan5_container }}">

        <div name="gridGroupSpan5_content" class="{{ $gridGroupSpan5_content }}">


            <div>
                <h4 class="{{ $textStyle }}">Currently Onsite</h4>
                <h2 class="{{ $headerStyle }}">
                    <a 
                        href="#" 
                        wire:click="$dispatch('openModal', { 
                            component: 'ModalOnsite' 
                        })"
                    >                    
                        {{ $total }}
                </a>
                </h2>
            </div>


        </div>

    </div>

</div>
