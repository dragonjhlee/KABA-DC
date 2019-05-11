/**
 * External dependencies
 */
import React, { Fragment } from 'react';
import PropTypes from 'prop-types';
import AutosizeInput from 'react-input-autosize';

/**
 * Wordpress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import { Clipboard, Pencil } from '@moderntribe/common/icons';
import './style.pcss';

const TicketContainerHeaderTitle = ( {
	hasAttendeeInfoFields,
	isDisabled,
	isSelected,
	onTempTitleChange,
	tempTitle,
	title,
} ) => (
	<div className="tribe-editor__ticket__container-header-title">
		{
			isSelected
				? (
					<Fragment>
						<AutosizeInput
							className="tribe-editor__ticket__container-header-title-input"
							value={ tempTitle }
							placeholder={ __( 'Ticket Type', 'event-tickets' ) }
							onChange={ onTempTitleChange }
							disabled={ isDisabled }
						/>
						{ hasAttendeeInfoFields && <Clipboard /> }
					</Fragment>
				)
				: (
					<Fragment>
						<h3 className="tribe-editor__ticket__container-header-title-label">
							{ title }
						</h3>
						<Pencil />
					</Fragment>
				)
		}
	</div>
);

TicketContainerHeaderTitle.propTypes = {
	hasAttendeeInfoFields: PropTypes.bool,
	isDisabled: PropTypes.bool,
	isSelected: PropTypes.bool,
	onTempTitleChange: PropTypes.func,
	tempTitle: PropTypes.string,
	title: PropTypes.string,
};

export default TicketContainerHeaderTitle;
