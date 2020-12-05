<?php
/**
 * Admin Page
 *
 * @package Free Images
 */

defined( 'ABSPATH' ) or exit;

?>

<div class="wrap free-images">

	<div class="wp-header">
		<div class="search-form">
			<label class="screen-reader-text" for="search-image"><?php _e( 'Free Images', 'free-images' ); ?></label>
			<input placeholder="<?php _e( 'Search your favorite images..', 'free-images' ); ?>" type="search" aria-describedby="live-search-desc" id="search-image">

			<div class="links">
				<ul>
					<li>
						<a href="https://maheshwaghmare.com/?p=8155" target="_blank"><?php esc_html_e( 'Quick Start Guide', 'free-images' ); ?> <i class="dashicons dashicons-external"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="wp-filter hide-if-no-js">
		<div class="filter-count">
			<span class="count images-count"></span>
		</div>

		<ul class="filter-links">
			<li><a href="#" data-slug="latest" class="current"><?php _e( 'Latest', 'free-images' ); ?></a></li>
			<li><a href="#" data-slug="upcoming"><?php _e( 'Upcoming', 'free-images' ); ?></a></li>
			<li><a href="#" data-slug="popular"><?php _e( 'Popular', 'free-images' ); ?></a></li>
			<li><a href="#" data-slug="ec"><?php _e( 'Editors Choice', 'free-images' ); ?></a></li>
		</ul>

		<select class="filter-categories">
			<option value=""><?php _e( 'All Categories', 'free-images' ); ?></option>
			<option value="animals"><?php _e( 'Animals', 'free-images' ); ?></option>			
			<option value="buildings"><?php _e( 'Architecture/Buildings', 'free-images' ); ?></option>
			<option value="backgrounds"><?php _e( 'Backgrounds/Textures', 'free-images' ); ?></option>
			<option value="fashion"><?php _e( 'Beauty/Fashion', 'free-images' ); ?></option>
			<option value="business"><?php _e( 'Business/Finance', 'free-images' ); ?></option>
			<option value="computer"><?php _e( 'Computer/Communication', 'free-images' ); ?></option>
			<option value="education"><?php _e( 'Education', 'free-images' ); ?></option>
			<option value="feelings"><?php _e( 'Emotions', 'free-images' ); ?></option>
			<option value="food"><?php _e( 'Food/Drink', 'free-images' ); ?></option>
			<option value="health"><?php _e( 'Health/Medical', 'free-images' ); ?></option>
			<option value="industry"><?php _e( 'Industry/Craft', 'free-images' ); ?></option>
			<option value="music"><?php _e( 'Music', 'free-images' ); ?></option>
			<option value="nature"><?php _e( 'Nature/Landscapes', 'free-images' ); ?></option>
			<option value="people"><?php _e( 'People', 'free-images' ); ?></option>
			<option value="places"><?php _e( 'Places/Monuments', 'free-images' ); ?></option>
			<option value="religion"><?php _e( 'Religion', 'free-images' ); ?></option>
			<option value="science"><?php _e( 'Science/Technology', 'free-images' ); ?></option>
			<option value="sports"><?php _e( 'Sports', 'free-images' ); ?></option>
			<option value="transportation"><?php _e( 'Transportation/Traffic', 'free-images' ); ?></option>
			<option value="travel"><?php _e( 'Travel/Vacation', 'free-images' ); ?></option>
		</select>

		<span class="safesearch">
			<label>
				<input type="checkbox" name="SafeSearch" value="1" checked="checked" id="safesearch-input" /> <?php _e( 'SafeSearch', 'free-images' ); ?>
			</label>
		</span>

		<span class="filter-color-wrap"><span class="select-color-label">Filter by Color </span><span class="selected-color"></span>
		    <span class="filter-colors-wrap" style="display: none;">
		    	<span class="filter-colors">
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-grayscale" data-color-name="grayscale"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-transparent" data-color-name="transparent"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-red" data-color-name="red"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-orange" data-color-name="orange"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-yellow" data-color-name="yellow"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-green" data-color-name="green"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-turquoise" data-color-name="turquoise"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-blue" data-color-name="blue"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-lilac" data-color-name="lilac"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-pink" data-color-name="pink"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-white" data-color-name="white"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-gray" data-color-name="gray"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-black" data-color-name="black"></span>
		            </span>
		            <span class="filter-color">
		                <span class="filter-color-name filter-color-brown" data-color-name="brown"></span>
		            </span>
		        </span>
		    </span>
		</span>

		<span class="page-navigation"></span>
	</div>

	<div id="free-images"></div>
</div>

<?php
/**
 * List
 */
?>
<script type="text/template" id="tmpl-free-images-list">
	<# if( data ) { #>
		<div class="image">
			<div class="inner">
				<span class="lightbox" data-id="{{data.id}}" data-preview-url="{{data.previewURL}}" data-user-image="{{data.userImageURL}}" data-url="{{data.largeImageURL}}" data-user="{{data.user}}" data-user-name="{{data.user}}" href="{{data.webformatURL}}" data-user-url="https://pixabay.com/users/{{data.user}}" data-page-url="{{data.pageURL}}">
					<img src="{{data.webformatURL}}" /></span>
					<noscript>
						<img src="{{data.webformatURL}}" />
					</noscript>
				<div data-url="{{data.largeImageURL}}" class="preview-and-download" data-user-name="{{data.user}}" data-user-url="https://pixabay.com/users/{{data.user}}" data-page-url="{{data.pageURL}}"></div>
				<div class="meta">
					<span class="user" data-user-id="{{data.user_id}}">
						<img src="{{data.userImageURL}}" class="user-image-url">
						<span class="user-name">{{data.user}}</span>
					</span>
					<span class="activities">
						<span class="likes"><span class="fa fa-thumbs-o-up"></span>{{data.likes}}</span>
						<span class="views"><span class="fa fa-eye"></span>{{data.views}}</span>
					</span>
				</div>
			</div>
		</div>
	<# } #>
</script>

<?php
/**
 * Page Navigation
 */
?>
<script type="text/template" id="tmpl-free-images-page-navigation">
	<span class="page-count"> {{ data.page }} / {{ parseInt( data.total / 20 ) }}</span>
	<button class="previous-page"><span class="screen-reader-text">Previous</span></button>
	<button class="next-page"><span class="screen-reader-text">Next</span></button>
</script>

<?php
/**
 * Found Image String
 */
?>
<script type="text/template" id="tmpl-free-images-found-images">
	<# if ( data ) { #>
	<span class="found-images">{{data.total}} Free images of <b>{{data.search_term}}</b></span>
	<# } #>
</script>

<?php
/**
 * Debug Info
 */
?>
<script type="text/template" id="tmpl-free-images-debug-info">
	<# if ( data ) { #>
		<span class="debug-info">
			<table>
				<tr><th><?php _e( 'API Request Limit', 'free-images' ); ?></th><td>{{data.limit}}</td></tr>
				<tr><th><?php _e( 'API Request Remaining', 'free-images' ); ?></th><td>{{data.remaining}}</td></tr>
				<tr><th><?php _e( 'API Request Reset', 'free-images' ); ?></th><td>{{data.reset}}</td></tr>
				<tr><th rowspan="2">
					<?php
					/* translators: %1$s is api rate limit link. */
					printf( __( '<a href="%1$s" target="_blank">Read more ></a>', 'free-images' ), 'https://pixabay.com/api/docs/#api_rate_limit' );
					?>
				</td></tr>
			</table>
		</span>
	<# } #>
</script>
