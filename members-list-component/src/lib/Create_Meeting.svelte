<script>
	import { fade } from 'svelte/transition';
    import { Datepicker } from 'svelte-calendar';

	let visible = false;
    let meetingTopic = '';
    function showForm() {
        visible = !visible;
    }

</script>

{#if !visible}
<button on:click={showForm}>
    Create a Meeting
</button>
{/if}

{#if visible}
	<section transition:fade>
        <input bind:value={meetingTopic} placeholder="enter your name">
        <label >Meeting Date:
            <Datepicker selected={new Date()}/>
        </label>
    </section>
{/if}

<style>
    button {
      font-family: inherit;
      font-size: inherit;
      padding: 1em 2em;
      color: #ff3e00;
      background-color: rgba(255, 62, 0, 0.1);
      border-radius: 2em;
      border: 2px solid rgba(255, 62, 0, 0);
      outline: none;
      width: 200px;
      font-variant-numeric: tabular-nums;
      cursor: pointer;
    }

    button:focus {
      border: 2px solid #ff3e00;
    }

    button:active {
      background-color: rgba(255, 62, 0, 0.2);
    }
  </style>
