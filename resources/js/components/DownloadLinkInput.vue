<template>
    <label for="dlInput">Download link</label>
    <div class="input-group">
        <input type="text" class="form-control" id="dlInput" name="downloadLink" required
            :value="downloadLink" />
        <a class="btn btn-primary">Test link</a>
    </div>
    <span id="dlParsedHintContainer" class="text-muted" style="display: none;">Preview: <span id="dlParsedHint"></span></span>
    <details>
        <summary>Available variables</summary>
        <!-- <p>%ver% = {{ isset($app->version) ? $app->version : '' }}<br/>
        %verMajorMinor% = {{ isset($app->version) ? $app->version : '' }}<br/>
        %verDotless% = {{ isset($app->version) ? $app->version : '' }}</p> -->
    </details>
</template>

<script lang="ts" setup>
    import { ref } from 'vue';

    const props = defineProps({
        link: String
    });

    const downloadLink = ref(props.link);
    console.log(props.link);
</script>
