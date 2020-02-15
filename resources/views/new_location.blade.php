<!-- add location -->
<div class="search-options">
    <form id="add-new-location" method="POST">
    {{ csrf_field() }}
        <fieldset>
            <legend>New location information</legend>
            <label>Name:</label>
            <input name="location_name" type="text" id="new-location-name" required/>   
            <input id="create-location" type="submit" value="Save" />
            <input id="cancel-create-location" type="button" value="Cancel" onclick="location.reload()"/>
        </fieldset>
    </form>
</div>