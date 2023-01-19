<template>
    // ...

    <div class="p-2 bg-blue-100">

        <!-- cards -->
        <draggable class="flex-1 overflow-hidden" v-model="status.cards" v-bind="cardDragOptions"
            @end="handlecardMoved">

            <transition-group class="flex-1 flex flex-col h-full overflow-x-hidden overflow-y-auto rounded shadow-xs"
                tag="div">

                <div v-for="card in status.cards" :key="card.id"
                    class="mb-3 p-3 h-24 flex flex-col bg-white rounded-md shadow transform hover:shadow-md cursor-pointer">


                </div>

            </transition-group>
        </draggable>

    </div>


</template>

<script>
import draggable from "vuedraggable"; // import the vuedraggable component

export default {
    components: { draggable, AddCardForm }, // register component
    // ...
    computed: {
        cardDragOptions() {
            return {
                animation: 200,
                group: "card-list",
                dragClass: "status-drag"
            };
        }
    },
    // ...
    methods: {

        handleCardMoved() {
            // Send the entire list of statuses to the server
            axios.put("/cards/sync", { columns: this.statuses }).catch(err => {
                console.log(err.response);
            });
        },
        // set the statusId and trigger the form to show
        openAddCardForm(statusId) {
            this.newCardForStatus = statusId;
        },
        // reset the statusId and close form
        closeAddCardForm() {
            this.newCardForStatus = 0;
        },
        // add a Card to the correct column in our list
        handleCardAdded(newCard) {
            // Find the index of the status where we should add the Card
            const statusIndex = this.statuses.findIndex(
                status => status.id === newCard.status_id
            );

            // Add newly created Card to our column
            this.statuses[statusIndex].Cards.push(newCard);

            // Reset and close the AddCardForm
            this.closeAddCardForm();
        },
    }
};


</script>

<style scoped>
.status-drag {
    transition: transform 0.5s;
    transition-property: all;
}
</style>
