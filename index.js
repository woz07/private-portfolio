/**
 * Function to make program sleep
 * @param miliseconds How long you want the sleep to last for (in ms)
 */
function SLEEP(miliseconds) {
    return new Promise(resolve => setTimeout(resolve, miliseconds));
}

/*
Header
*/

/**
 * Function to load data to screen
 */
async function load() {
    /**
     * Function that manipulates html elements to have target as text
     * @param element   The target element which gets changed
     * @param target    The target output to put into element
     */
    async function update(element, target) {
        for (let i = 0; i < target.length; i++) {
            element.text(target.substring(0, i + 1));
            await SLEEP(100);
        }
    }

    // Load #greeting
    await update($("#greeting"), "Hello,");
    await SLEEP(200);
    // Load #name
    await update($("#name"), "I'm Sameer.");
}

load();
