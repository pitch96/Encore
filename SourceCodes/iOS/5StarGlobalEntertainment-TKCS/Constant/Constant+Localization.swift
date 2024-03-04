//
//  Constant.swift
//  
//
//  Created by chetu on 22/11/22.
//

import Foundation

class AppMessage{
    static let shared: AppMessage = {
        let instance = AppMessage()
        return instance
    }()
    
    // MARK: - LOGIN VIEW CONTROLLER MESSAGES
    let Email = "locEmail".localized
    let Password = "locPassword".localized
    let pleaseEnterEmailAddress = "locPleaseEnterEmailAddress".localized
    let pleaseEnterValidEmailAddress = "locPleaseEnterValidEmailAddress".localized
    
    // MARK: - SIGNUP VIEW CONTROLLER MESSAGES
    let FirstName = "First Name".localized
    let LastName = "Last Name".localized
    let PhoneNumber = "(123)-456-7890".localized
    let Company = "Company Name".localized
    let ConfirmPassword = "Confirm Password".localized
    let PleaseEnterFirstName = "locPleaseEnterFirstName".localized
    let PleaseEnterValidFirstName = "locPleaseEnterValidFirstName".localized
    let PleaseEnterLastName = "locPleaseEnterLastName".localized
    let PleaseEnterValidLastName = "locPleaseEnterValidLastName".localized
    let PleaseEnterPhone = "Please enter phone number.".localized
    let PleaseEnterValidPhone = "Please enter valid phone number.".localized
    let PleaeEnterCompanyName = "Please enter company name.".localized
    let PleaseEnterValidCompanyName = "Please enter valid company name.".localized
    let PleaseEnterPassword = "Please enter password.".localized
    let PleaseEnterValidPassword = "Password must be 8 characters and contain One uppercase and lowercase,special character and number.".localized
    let PleaseEnterConfirmPassword = "Please enter confirm password.".localized
    let PasswordAndConfirmPassword = "Password and confirm password must be same.".localized
    let MismatchPassword = "Paasword confirm password mismatch.".localized
    
    // MARK: - Forget Password View Controller
    let Emails = "Email".localized

    // MARK: - Reset password View controller
    let Otp = "OTP".localized
    let Warning = "Warning".localized
    let CameraWarning = "You don't have camera".localized
    let NewPass = "New password".localized
    let ConfirmPass = "Confirm Password".localized

    // MARK: - HOME VIEW CONTROLLER
    let DateText = "locDateText".localized
    let SearchText = "locSearchText".localized
    
    // MARK: - SIde menu view controller

    let logoutMessage = "Are you sure you want to logout!".localized
    // MARK: - Ticket View Controller
    let NoMoreticket = "locNoTicket".localized
    let SelectTicket = "locSelectTicketType".localized
    
    // MARK: - PROFILE VIEW CONTROLLER
    let Username = "locUsername".localized
    let EnterValidUsrename = "locValidUsername".localized
    let Fullname = "locFullname".localized
    let ValidFullname = "locValidFullname".localized
    let contactNumber = "locContact".localized
    let EnterValidContact = "locValidContact".localized
    let PickPhoto = "locPickPhoto".localized
    let ChooseLibrary = "locChooseLibrary".localized
    let Camera = "locCamera".localized
    let Gallary = "locGallary".localized
    let Cancel = "locCancel".localized

    // MARK: - Create Event View Controller
    let EventTitle = "locEnterEvent".localized
    let EventCategory = "locEnterCategory".localized
    let EventOrganizer = "locEnterOrganizer".localized
    let EventStartDate = "locEnterStartDate".localized
    let EventEndDate = "locEnterEndDate".localized
    let EventStartTime = "locEnterStartTime".localized
    let EventEndTime = "locEnterEndTime".localized
    let EventVenue = "locEnterVenue".localized
    let EventAddress = "locEnterAdress".localized
    let EventCity = "locEnterCity".localized
    let EventZipCode = "locEnterZipCode".localized
    let EventDescription = "locEnterDescription".localized
    let TimeStamp =  "please choose a time stamp".localized
    
    // MARK: - Manage Event View Controller
    let YesAction  = "Yes".localized
    let LiveEvent = "Are you sure, you want to make live this event?".localized
    let RemoveLiveEvent = "Are you sure, you want to remove this event from live?".localized
    let DeleteUser = "Are you sure, you want to delete this user?".localized
    let DeleteEvent = "Are you sure, you want to delete this event?".localized
    let DeletePromoter = "Are you sure, you want to delete this promoter?".localized
    let TitleEvent = "Are you sure?".localized

    // MARK: - Payment checkout view controller
    let EnterState =  "Please enter state.".localized
    let EnterCity = "Please enter city.".localized
    let EnterZipcode = "Please enter zipcode".localized
    let EnterValidZipcode =  "Please enter valid zipcode".localized
    let EnterAddress =  "Please enter address.".localized

    // MARK: - Payment View Controller
    let EnterCardHolderName = "Please enter card holder name.".localized
    let EnterCardNumber = "Please enter card number.".localized
    let EnterValidCardNumber = "Please enter valid card number.".localized
    let EnterCardExpiryMonth  = "Please enter expiry month.".localized
    let EnterValidExpiryMonth  = "Please enter valid expiry month.".localized
    let EnterCardExpiryYear  = "Please enter expiry year.".localized
    let EnterValidExpiryYear = "Please enter valid expiry year".localized
    let EnterCardCvv = "Please enter cvv.".localized
    
    // MARK: - Create ticket view Controller
    let EnterEventTitle = "Please enter event title.".localized
    let EnterTicketTitle = "Please enter ticket title.".localized
    let EnterTicketType = "Please select ticket type.".localized
    let EnterTicketQuantity = "Please enter ticket quantity.".localized
    let EnterTicketPrice = "Please enter ticket price.".localized
    let EnterValidPrice = "Please enter valid price.".localized
    let EnterEndDate = "Please enter end date.".localized
    let EnterValidEndDate = "Please enter valid end date.".localized
    let EnterEndTime = "Please enter end time.".localized
    let EnterPrice = "Please enter price".localized
    let EnterActivateTicket = "Are you sure, you want to activate this ticket??".localized
    let EnterDeactivateTicket = "Are you sure, you want to deactivate this ticket?".localized
    let DeleteTicket = "Are you sure, you want to delete this ticket?".localized

   // MARK: - ADD Banner
    let EnterDescription = "Please enter description".localized
    let SelectImage = "Please select image".localized
    let RecordFound = "The record has been found successfully!".localized
    let QRcodeScanned = "QR code already scanned!".localized
    let CameraAccess = "Camera is required to use in this application".localized
    let ActivateBanner = "Are you sure, you want to activate this banner?".localized
    let DeactivateBanner = "Are you sure, you want to deactivate this banner?".localized
    let EventRunning = "Event Running right now.".localized
    let EventExpired = "Event Expired right now.".localized
    let AdminApproval = "Please wait for admin approval. Your request is in progress.".localized
    let RejectedRequest = "Your request is rejected by admin.".localized
    let RefferalMsg = "Refer this event with your friends and get some referral amount."
    let DeletAccount = "Are you Sure, You want to delete this account".localized
    let DeleteConfirm = "Your request to delete account has been sent successfully".localized
    let TakeApproval = "First take approval by admin.".localized
    let GetAccess = "GetAccess".localized
    let RemovePopularEvent = "Are you sure, you want to remove this event from popluar event List?".localized
    let MakePopularEvent = "Are you sure, you want to make live this event as popular?".localized
    let VerifyPromoter = "Are you sure, you want to verify this promoter?".localized
    let DeclinePromoter = "Are you sure, you want to mark this promoter as non-verified?".localized
    let AdminResponce = "Wait for Admin's response for this event.".localized
    let ExpiredEvent = "Event expired already. Cannot make it Live now.".localized
    let PopularByEventStatus = "If you want to popular this event first you need to live the event.".localized
    let EnterAmount = "Please enter amount.".localized
    let ValidAmount = "Please enter valid ammount.".localized
    let ActionError = "You are not allowed to perform this action.".localized
    let FirstLiveEvent = "If you want to popular these event first you need to live the event.".localized
    let RejectedEvent = "Event can not be switch to live because admin rejected the request.".localized
}
