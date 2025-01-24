<div>
   <div role="tablist" class="tabs tabs-lifted">
  <input type="radio" name="my_tabs_2" role="tab"  checked="checked" class="tab" aria-label="Event" />
  <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
    <livewire:admin.people.event :user_id="$user_id">
  </div>

  <input
    type="radio"
    name="my_tabs_2"
    role="tab"
    class="tab "
    aria-label="Tab 2"
    />
  <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
    Tab content 2
  </div>

  <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Tab 3" />
  <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
    Tab content 3
  </div>
</div>
</div>
