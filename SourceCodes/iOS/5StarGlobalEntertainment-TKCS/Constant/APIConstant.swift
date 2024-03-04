//
//  APIConstant.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/11/22.
//

import Foundation

// MARK: Tokey Key
struct Tokenkey{
    static let userLogin = "token"
    static  let UsersTypes = "userType"
    static let email = "email"
    static let password = "password"
    
}
enum DefaultValue: String{
    case UserID = "userID"
    case emptyString = ""
    case Paid = "Paid"
    case Free = "Free"
    case defaultUser = "0"
    case space = ", "
    case user = "2"
    case address = "Address"
    case promoter = "3"
    case ranges = "[^0-9]"
    case numberFormat = "(XXX)-XXX-XXXX"
    case all = "All"
    case ok = "OK"
    case done = "Done"
    case cancel = "Cancel"
    case login = "Login"
    case inputDateFormat = "YYYY-MM-dd"
    case yearFormat = "yyyy"
    case imagePerson = "person.fill"
    case outputDateFormat = "MM/dd/yyyy"
    case inputTimeFormat = "HH:mm"
    case outputTimeFormat = "hh:mm a"
    case DigitRange = "0123456789"
    case loginFirst = "Please login first!"
    case selectTime = "Select Time"
    case contentController = "contentViewController"
    case select = "---Select---"
    case query = "Type your query..."
    case updatedUser = "Update User"
    case updatedPromoter = "Update Promoter"
    case plusImage = "plus.circle.fill"
    case minusImage = "minus.circle.fill"
    case description = "Description"
    case image = "image"
    case collapsed = "collapsed"
    case expand = "expand"
    case logOut = "Logout"
    case WrongTicket = "worngTicket"
    case ValidTicket = "validTicket"
    case GuestArrived = "Guest Arrived!"
    case AlreadyScanned = "allreadyScanned"
    case AlreadyCheckIn = "Already Checked-In!"
    case white = "White"
    case left = "left"
    case Arial = "Arial"
    case BannerImage = "banner_image"
    case Standard = "Standard"
    case Locale = "en_US_POSIX"
    case imageBanner = "banner_image[]"
    case arrDescription = "description[]"
    case errorMsg = "Something went wrong"
    case AllCategory = "All Categories"
    case InProgress = "In-Progress"
    case Approved = "Approved"
    case Rejected = "Rejected"
    case Expired = "Expired"
    case Pending = "Pending"
}
// MARK: - side bar option for buyer
struct Sideoption {
    static let AboutUs = "About Us"
    static let ContactUS = "Contact Us"
    static let TermsCondintion = "Terms & Conditions"
    static let MyAccount = "My Account"
    static let MyCart = "My Cart"
    static let MyOrder = "My Order"
    static let AccountDelete = "Account Delete"
    static let LogOut = "Logout"
}
// MARK: - Side bar option for Admin and Promoter
struct OptionAdminPromoter {
    static let User = "Users"
    static let ManageUser = "Manage Users"
    static let ManagePromoter = "Manage Promoters"
    static let Category = "Category"
    static let CreateCategory = "Create Category"
    static let ManageCategory = "Manage Category"
    static let EventCharge = "Event Charge"
    static let UpdateCharge = "Update charge"
    static let Events = "Events"
    static let CreateEvents = "Create Events"
    static let MyEVents = "My Events"
    static let EventDetails = "Event Details"
    static let MyPurchases = "My Purchases"
    static let Tickets = "Tickets"
    static let CreateTicket = "Create Ticket"
    static let ManageTicket = "Manage Ticket"
    static let PromotionalEvents = "Promotional Events"
    static let SubscribedUser = "Subscribed Users"
    static let SubscriberList = "Subscribed Users List"
    static let Banner = "Banner"
    static let AddBanner = "Add Banner"
    static let ManageBanner = "Manage Banner"
    static let Scanner = "Scanner"
    static let ScanTicket = "Scan Ticket"

    
}

// MARK: - Login API parameter
struct LoginApiParam{
    static let email =  "email"
    static let password =  "password"
}
// MARK: - Reset password API param
struct ResetPasswordApiParam{
    static var otp = "otp"
    static var email = "email"
    static var password = "password"
    static var password_confirmation = "password_confirmation"
    
}
// MARK: - Resend API param
struct ResendOtpApiParam{
    static let email = "email"
    
}
// MARK: - Ticket API param
struct TicketApiParam{
    static let eventId = "event_id"
}
// MARK: - Signup API param
struct SignUpApiParam{
    static let user_type = "user_type"
    static let first_name = "first_name"
    static let last_name = "last_name"
    static let email = "email"
    static let phone_no = "phone_no"
    static let company_name = "company_name"
    static let password = "password"
    static let password_confirmation = "password_confirmation"
    
}
// MARK: - Profile API Param
struct ProfileApiParam{
    static let first_name = "first_name"
    static let last_name = "last_name"
    static let phone_no = "phone_no"
    static let company_name = "company_name"
    static let user_profile = "user_profile"
}
// MARK: - Contact us API param
struct ContactUsApiParam{
    static let name = "name"
    static let email = "email"
    static let phone_no = "phone_no"
    static let queries = "queries"
}
// MARK: - Add to cart API param
struct AddToCartParam{
    static let userID = "user_id"
    static let ticketID = "ticket_id"
    static let quantity = "ticket_qty"
}
// MARK: - Delete Cart API param
struct DeleteCartParam{
    static let id = "id"
}
// MARK: - Placed order API param
struct PlacedOrderParam{
    static let userId = "user_id"
    static let cartItems = "cart_items"
    static let totalPrice = "total_price"
    static let billingAddressId = "active_address_id"
    static let fullName = "full_name"
    static let phoneNumber = "phone_no"
    static let email = "email"
    static let state = "state"
    static let city = "city"
    static let zipcode = "zipcode"
    static let address = "address"
    static let stripeToken = "stripeToken"
}
// MARK: - Update user API param
struct UpdateUserParam{
    static let first_name = "first_name"
    static let last_name = "last_name"
    static let phone_no = "phone_no"
    static let company_name = "company_name"
    
}

struct Scanner{
    static let ticket_no = "ticket_no"
}
// MARK: - Update ticket API Param
struct updateTicketParam{
    static let event_id = "event_id"
    static let ticket_title = "ticket_title"
    static let ticket_type = "ticket_type"
    static let total_qty = "total_qty"
    static let ticket_price = "ticket_price"
    static let end_date = "end_date"
    static let end_time = "end_time"
    
}
// MARK: - Update event API Param
struct UpdateEventParam{
    static let category_id = "category_id"
    static let event_title = "event_title"
    static let organizer = "organizer"
    static let venue = "venue"
    static let address = "address"
    static let city = "city"
    static let zipcode = "zipcode"
    static let start_date = "start_date"
    static let end_date = "end_date"
    static let start_time = "start_time"
    static let end_time = "end_time"
    static let description = "description"
    static let image = "image"
    
}
// MARK: - Update category API param
struct UpdateCategoryParam{
    static let name = "name"
}
// MARK: - Add category API param
struct AddCategoryParam{
    static let name = "name"
}
// MARK: - Create ticket API param
struct CreateTicketParam{
    static let event_id = "event_id"
    static let ticket_title = "ticket_title"
    static let ticket_type = "ticket_type"
    static let total_qty = "total_qty"
    static let ticket_price = "ticket_price"
    static let end_date = "end_date"
    static let end_time = "end_time"
    static let user_id = "user_id"
    
}
// MARK: - Create event API Param
struct CreateEventParam{
    static let category_id = "category_id"
    static let event_title = "event_title"
    static let organizer = "organizer"
    static let venue = "venue"
    static let address = "address"
    static let city = "city"
    static let zipcode = "zipcode"
    static let start_date = "start_date"
    static let end_date = "end_date"
    static let start_time = "start_time"
    static let end_time = "end_time"
    static let description = "description"
    static let image = "image"
}
// MARK: - API method
enum Service: String{
    case post = "POST"
    case get = "GET"
    case put = "PUT"
    case delete = "DELETE"
}

var imageURL = "https://5starglobalentertainment-qa.chetu.com/event-images/"
// MARK: - BaseURL

// var baseURL = "https://5starglobalentertainment-qa.chetu.com/api/"
// MARK: - Stagging URL
 // var baseURL = "https://tickets.encoreevents.live/api/"

// MARK: - Production URL
var baseURL = "https://encoreevents.live/api/"

// MARK: - Stripe Keys
enum API: String{
    case testStripePublishKey = "pk_test_51LTUDwAZeADNyTCBN7zrxfnUkaFlrKymrvj9gzQqfCLkihC42FDpwzm8Y3m7Nodg6ddli3UF3A4i2p41D6kEXNPL00nNUFIVrH"
    case liveStripePublishKey = "pk_live_51LTUDwAZeADNyTCBUB3BXmyfvKRWml61bWBvHAX6O1tUVGaD9YQ2hIVXRIRkd311m4gyYFWmAVJ0rvGQVWiA0eGf00LAvc2SVo"
    // MARK: - LOGIN
    case register = "register"
    case login = "login"
    case forgetPassword = "forgot/password"
    case resetPassword = "reset/password"
    case resendOTP = "resend/otp"
    case searchByEvent = "search/events"
    
    // MARK: - HOME PAGE
    case homePage = "homepage"
    case catagoryEventById = "search/events/"
    case filterEvent = "filter/events"
    case catagories = "categories"
    case banners = "banners"
    case eventDetail = "event/details/"
    case GetEventDetails = "event/detail"
    
    // MARK: - PROFILE
    case account = "account"
    case updateProfile = "update/profile"
    // MARK: Ticket-------
    case ticket = "tickets"
    // MARK: - Logout
    case logout = "logout"
    // MARK: - Contact Us
    case contactus = "contactus"
    
    // MARK: - ADD TO CART
    case addToCart = "addToCart"
    
    // MARK: - Update Cart
    case updateCart = "updateCart"
    
    // MARK: - CHECKOUT
    case checkout = "checkout"
    
    // MARK: - Delete Cart Item
    case deleteCartItem = "deleteCartItem"
    // MARK: Placed Order
    case placeOrder = "placed/order"
    // MARK: OrderDetail--
    case OrderDetail = "my/order"
    
    case AboutUs = "aboutus"
    case PrivacyPolicy = "privacy/policy"
    case TermsCondition = "terms/conditions"
    case Subscribe = "subscribe"
    case ManageUsers = "admin/manage/users"
    case ManagePromoter = "admin/manage/promoters"
    case GetUser = "admin/get/user"
    case DeleteUser = "admin/delete/user"
    case updateUser = "admin/update/user"
    case addCategory = "admin/category"
    case ManageCategory = "admin/categories"
    case CreateEvent = "admin/event"
    case ManageEvents = "admin/events"
    case getTickets = "admin/tickets"
    case CreateTicket = "admin/ticket"
    case GetAllEvent = "admin/events?events=all_events"
    case ReferLink = "CheckStripeAccount"
    case BannerImages = "admin/banner/images"
    case AddBanner = "admin/save/banner"
    case GetSubscriberList = "subscribed/users/list"
    case GetBannerData = "admin/edit/banner"
    case UpdateBanner = "admin/update/banner"
    case DeleteBanner = "admin/delete/banner"
    case changeBanner = "change/banner"
    case qrDetails = "qrDetails"
    case TicketDetail = "getTicektNo"
    case TotalTicket = "totalTicket"
    case OrderHistory = "myEventOrder"
    case Payout = "totalPayout"
    case ExpiredEvent = "myEventDetails?events=expired_events"
    case RunningEvent = "myEventDetails"
    case GuestList = "admin/event/orders/details"
    case PromotionalList = "admin/promotion/list"
    case FreePromotionList = "admin/promotion/list?events=free_events"
    case PayAmmount = "pay$1000"
    case AdminApprovalAction = "admin/promotion/action"
    case updateCharge = "admin/update/charge"
    case PopularEvent = "admin/change/popular/status"
    case makeOwnPromoter = "admin/verify/promoter"
    
    
}
// MARK: - Create 
struct Alert{
    static let okTitle = "Ok"
    static let Error = "Error"
    static let projectName = "Encore Events"
    static let cancelTitle = "Cancel"
    static let copy = "Copy"
    static let changeStatus = "Change Status"
}
struct Biometric {
    static let reason = "Unlock device"
    static let FaceId = "Unlock using Face ID"
    static let TouchId = "Unlock using Touch ID"
    static let None = "No Biometric support"
}
 
