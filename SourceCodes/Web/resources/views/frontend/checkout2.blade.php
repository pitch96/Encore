@extends('frontend.layouts.default')
@section('title', 'My Cart')
@section('style')
    
@endsection
@section('content')

		<!-- Start Checkout section -->
		<section class="checkout-section section-gapping">
			<div class="container">
				<h2 class="main-title">
					Event Ticket
				</h2>
				<div class="event-tickets">
					<div class="event-ticket-table">
						<table>
							<thead>
								<tr>
								<th class="ticket-title">Images</th>
								<th class="ticket-detail ticket-title">Event Title</th>
								<th class="ticket-title">Ticket Title</th>
								<th class="ticket-detail ticket-title">Unit Prices</th>
								<th class="ticket-title">Quantity</th>
								<th class="ticket-detail ticket-title">Amount</th>
								<th class="delete-ticket">Action</th>
								</tr>
							</thead>
							<tbody id="cartTable">
								@php
									$totalCartItems = 0;
									$totalPrice = 0;
									$cart_items = [];
								@endphp
								@forelse ($cartDatas as $item)
									@php
										$totalCartItems += $item->quantity;
										$totalPrice += $item->quantity * $item->ticket->price;
										array_push($cart_items, $item->id);
									@endphp
									<input type="hidden" class="total_no_of_ticket{{ $item->id }}" value="{{ $item->ticket->quantity }}">
									<input type="hidden" class="ticket_id{{ $item->id }}" value="{{ $item->ticket_id }}">
								<tr data-id="{{ $item->id }}">
									<td>
										<div class="event-img">
											<img src="{{ asset('event-images/' . $item->ticket->event->image) }}" alt="event">
										</div>
									</td>
									<td class="ticket-detail">
										<p>
											{{ Str::length($item->ticket->event->event_title) > 20 ? substr($item->ticket->event->event_title, 0, 20) . '...' : $item->ticket->event->event_title }}
										</p>
									</td>
									<td >
										<p>
											{{ $item->ticket->ticket_title }}
										</p>
									</td>
									<td class="ticket-detail">
										<p>
											$ <span class="price_per_head{{ $item->id }}">{{ $item->ticket->price }}</span>
										</p>
									</td>
									<td>
										<div class="qty-container">
											<button class="quantity-button qty-btn-minus btn-light manage-quantity" type="button" data-field="quantity" data-value="mins" data-id="{{ $item->id }}">
												<img src="{{ asset('frontend/images/icon-minus.png') }}" alt="minus">
											</button>
											<input type="text" name="qty" value="{{ $item->quantity }}" class="quantity-input input-qty quantity-field ticket_qty{{ $item->id }}" data-id="{{ $item->id }}" />
											<button class="quantity-button qty-btn-plus btn-light manage-quantity" type="button" data-field="quantity" data-value="plus" data-id="{{ $item->id }}">
												<img src="{{ asset('frontend/images/icon-plus.png') }}" alt="plus">
											</button>
										</div>
									</td>
									<td class="ticket-detail">
										<p>
											$ <span class="total_price{{ $item->id }}">{{ $item->quantity * $item->ticket->price }}</span>
										</p>
									</td>
									<td>
										<a href="javascript:void(0)" class="event-remove-ico deleteTicket"  data-cart_id="{{ $item->id }}">
											<img src="{{ asset('frontend/images/icon-remove.png') }}" alt="remove">
										</a>
									</td>
								</tr>
								@empty
									<tr class="sm-thrd">
										<td colspan="7" class="text-center text-white">Cart is empty</td>
									</tr>
								@endforelse
							</tbody>
						  </table>
					</div>
					<div class="event-ticket-order">
						<h2 class="event-ticket-title">
							Order Detail
						</h2>
						<ul class="event-ticket-list">
							<li>
								<p class="d-flex">
									<span id="priceTxtx">
										Price ({{ $totalCartItems }} items)
									</span>
									<span class="text-right sub_total">${{ $totalPrice }}</span>
								</p>
							</li>
							<li>
								<p class="d-flex">
									<span>
										Discount
									</span>
									<span class="text-right total_amount">$0</span>
								</p>
							</li>
							<li>
								<p class="d-flex checkout-order-total">
									<span>
										Total
									</span>
									<span class="text-right total_amount">${{ $totalPrice }}</span>
								</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="section-gapping accordionsection">
					<h2 class="main-title">
						Payment Checkout
					</h2>
					<br>
					<div class="accordion1">
						<div class="at-item1">
						  <div class="at-title1">
							<h4 class="blog-post-title category-title">Billing Address</h4>
						  </div>
						  <div class="at-tab1" style="display: block;">

							<form class="needs-validation validation_form accordion-form" novalidate="" id="billing_form">
								<input type="hidden" id="cart_items" value="{{ implode(',', $cart_items) }}">
								<input type="hidden" class="billing_data" name="active_address_id" id="active_address_id" value="{{ $active_address ? $active_address->id : '' }}" required>
								<div class="form-group">
									<div class="form-control">
										<label for="">Full Name</label>
										<input type="text" placeholder="Full Name" name="full_name"  value="{{ $active_address->full_name ?? '' }}" class="input-fields billing_data" required>
									</div>
									<div class="form-control">
										<label for="">Phone Number</label>
										<input type="number" placeholder="Phone Number" class="input-fields billing_data" name="phone_no" value="{{ $active_address->phone_no ?? '' }}" required>
									</div>
								</div>
								<div class="form-group">
									<div class="form-control">
									<label for="address">Address</label>
										<input type="text" placeholder="Address" class="input-fields billing_data" name="address" value="{{ $active_address->address ?? '' }}" required>
									</div>
									<div class="form-control form-group-inner">
									<div class="form-control-inner">
											<label for="">City</label>
											<input type="text" placeholder="City" class="input-fields billing_data" name="city" value="{{ $active_address->city ?? '' }}" required>
										</div>
										<div class="form-control-inner">
											<label for="">State</label>
											<input type="text" placeholder="State" class="input-fields billing_data" name="state" value="{{ $active_address->state ?? '' }}" required>
										</div>
										<div class="form-control-inner">
											<label for="">Zipcode</label>
											<input type="number" placeholder="Zipcode" class="input-fields billing_data" name="zipcode" value="{{ $active_address->zipcode ?? '' }}" required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="form-control full-control">
									<label for="">Email Address</label>
										<input type="email" placeholder="Email ID" class="input-fields billing_data checkout-email-address" name="email" value="{{ $active_address->email ?? '' }}" required>
										<!-- <input type="text" name="address" id="address" class="input-fields billing_data" placeholder="Address">{{ $active_address->address ?? '' }}"> -->
									</div>
								</div>
								<div class="form-group {{ $totalPrice >0 ? 'hidden' : '' }}" >
									<div class="form-control full-control">
									 
										<button class="btn-search btn-common checkout-submit-btn"  type="submit"
										@if ($totalPrice == 0) id="purches_ticket" @else id="billing-data" @endif
										>Place Order</button>
									 
									</div>
								</div>

							</form>

						  </div>
						</div>
						<br>
						<div class="at-item1 no-bg {{ $totalPrice==0 ? 'hidden' : '' }}">
						  <div class="at-title1">
							<h4 class="blog-post-title category-title">Payment Details</h4>
						  </div>
						  <div class="at-tab1" style="display: block;">
							 
							<div id="payment_option" class="collapse" aria-labelledby="faqhead2"
								data-parent="#faq">
								<div class="card-body">
									<form class="needs-validation validation_form validation" novalidate=""
										role="form" data-cc-on-file="false"
										data-stripe-publishable-key="{{ config('constants.STRIPE_KEY') }}"
										id="payment-form">
										@csrf
										<div class="form-row d-flex payment-details">
											<div class="d-flex payment-details">
											<div class="field-row ">
												<label class="ticket_label" for="name"> Card Holder Name </label>
												<input type="text"
													class="form-control cust-sel-size name-field input-fields"
													id="name" placeholder="Card Holder Name" value=""
													required maxlength="30" name="name">
											</div>

											<div class="field-row">
												<label class="ticket_label" for="card_no"> Credit/Debit Card </label>
												<input type="text"
													class="form-control cust-sel-size card_no input-fields"
													id="card_no" placeholder="Credit/Debit Card" name="card_no" value=""
													required>
											</div>
										     </div>
										 <div class="d-flex">

											<div class="field-row">
												<label class="ticket_label" for="month">Expiry Month</label>
												<input type="text" class="form-control cust-sel-size card_month input-fields"
													id="month" placeholder="MM" name="month" value=""
													required>
											</div>
											<div class="field-row">
												<label class="ticket_label" for="year">Expiry Year</label>
												<input type="text" class="form-control cust-sel-size year input-fields"
													id="year" placeholder="YYYY" value=""
													required name="year">
											</div>
											<div class="field-row">
												<label class="ticket_label"
													for="cvv">CVV</label>
												<input type="text" class="form-control cust-sel-size cvv input-fields"
													id="cvv" placeholder="CVV" value=""
													required name="cvv">
											</div>
										</div>

										</div>
										<div class='form-row row'>
											<div class='col-md-12 error form-group' style="display: none">
												<div class='alert-danger alert'>Fix the errors before you
													begin.
												</div>
											</div>
										</div>
										<div class="form-group checkout-submit-btn-content">
													<div class="form-control full-control checkout-submit-div">
														<a href="javascript:void(0)">
															<button class="btn-search btn-common checkout-submit-btn" id="buy_ticket"
															type="submit">Place Order</button>
														</a>
													</div>
										</div>
										<p class="border_line d-flex justify-content-between py-2 mb-3"> </p>
									</form>
								</div>
							</div>
						</div>
						  </div>
						</div>
					  </div>
				</div>
			</div>
		</section>
		<!-- End Checkout section -->

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/stripe.js?v=' . time()) }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/customjs/checkout.js?v=' . time()) }}"></script>
@endsection

