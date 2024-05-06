<div
    class="modal fade"
    id="eventModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Event</h5>
                <button
                    type="button"
                    class="btn-close button-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div>
                    <input type="hidden" id="eventId" />
                    <label for="title">Titre</label>
                    <input
                        type="text"
                        placeholder="Enter Title"
                        class="form-control"
                        id="title"
                        name="title"
                        value=""
                        required
                    />
                </div>
                <div>
                    <label for="is_all_day">Toute la journée</label>
                    <input
                        type="checkbox"
                        id="is_all_day"
                        name="is_all_day"
                        value=""
                        required
                    />
                </div>
                <div>
                    <label for="startDateTime">Début</label>
                    <input
                        type="text"
                        placeholder="Select Start Date"
                        readonly
                        class="form-control"
                        id="startDateTime"
                        name="startDate"
                        value=""
                        required
                    />
                </div>
                <div>
                    <label for="endDateTime">Fin</label>
                    <input
                        type="text"
                        placeholder="Select End Date"
                        readonly
                        class="form-control"
                        id="endDateTime"
                        name="endDate"
                        value=""
                        required
                    />
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea
                        placeholder="Enter Description"
                        class="form-control"
                        id="description"
                        name="description"
                    ></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-danger mr-auto button-delete"
                    style="display: none"
                    id="deleteEventBtn"
                   
                >
                    Supprimer
                </button>
                <button
                    type="button"
                    class="btn btn-primary button-save"
                    
                >
                    Sauvegarder
                </button>
            </div>
        </div>
    </div>
</div>
