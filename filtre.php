<div class="filters-container">


    <div class="filters">
        <div class="filter">

            <select name="categories-photos" id="filter-category" class="filter-category">
                <option value="default-category">Catégories</option>
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
                <option value="default-format">Formats</option>
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
                <option value="default-tri">Trier par</option>
                <?php
                $dates = get_terms(array(
                    'taxonomy' => 'date',
                    'hide_empty' => false,
                ));
                if (!empty($dates) && !is_wp_error($dates)) {
                    foreach ($dates as $date) {
                        echo '<option value="' . $date->slug . '">' . $date->name . '</option>';
                    }
                }
                ?>
            </select>
        </div>

    </div>
</div>