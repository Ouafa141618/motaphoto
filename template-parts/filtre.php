
<div class="filters-container">
    <div class="filters">
        <div class="filter">
            <select name="categories-photos" id="filter-category" class="filter-category">
                <option value="" disabled selected hidden>Catégories</option>
                <?php
                $categories = get_categories(array(
                    'taxonomy' => 'categories-photos',
                    'hide_empty' => false,
                ));
                foreach ($categories as $category) {
                    echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="filter">
            <select name="formats" id="filter-format" class="filter-format">
                <option value="" disabled selected hidden>Formats</option>
                <?php
                $formats = get_categories(array(
                    'taxonomy' => 'formats',
                    'hide_empty' => false,
                ));
                foreach ($formats as $format) {
                    echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="filter">
            <select name="tri" id="filter-tri" class="filter-tri">
                <option value="" disabled selected hidden>Trier par</option>
                <option value="date_desc">Du plus récent au plus ancien</option>
                <option value="date_asc">Du plus ancien au plus récent</option>
            </select>
        </div>
    </div>
</div>
