//
//  PromotionalModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 13/04/23.
//

import Foundation
// MARK: - CartModelData
struct PromotionalModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [PromotionalDetails]?
}

// MARK: - Datum
struct PromotionalDetails: Codable {
    var id, adminID: Int?
    var orderNo: String?
    var eventID, eventCreatedBy, promoterID: Int?
    var date: String?
    var amount: Int?
    var paymentStatus, paymentResponse, currency: String?
    var status: Int?
    var createdAt, updatedAt, eventStatus: String?
    var events: Events1?
    var promoter: Promoter?

    enum CodingKeys: String, CodingKey {
        case id
        case adminID = "admin_id"
        case orderNo = "order_no"
        case eventID = "event_id"
        case eventCreatedBy = "event_created_by"
        case promoterID = "promoter_id"
        case date, amount
        case paymentStatus = "payment_status"
        case paymentResponse = "payment_response"
        case currency, status
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case eventStatus = "event_status"
        case events, promoter
    }
}

// MARK: - Events
struct Events1: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime, image, description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var category: Category1?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case image, description, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case category
    }
}

// MARK: - Category
struct Category1: Codable {
    var id, userID: Int?
    var name: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case name, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}

// MARK: - Promoter
struct Promoter: Codable {
    var id, userType: Int?
    var firstName, lastName, email, phoneNo: String?
    var companyName: String?
   // var emailVerifiedAt: JSONNull?
    var status: Int?
    var userProfile: String?
  //  var deletedAt: JSONNull?
    var createdAt, updatedAt: String?
    var isEmailVerified: Int?

    enum CodingKeys: String, CodingKey {
        case id
        case userType = "user_type"
        case firstName = "first_name"
        case lastName = "last_name"
        case email
        case phoneNo = "phone_no"
        case companyName = "company_name"
        //case emailVerifiedAt = "email_verified_at"
        case status
        case userProfile = "user_profile"
        //case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case isEmailVerified = "is_email_verified"
    }
}
 // MARK: Free Event Model Details
struct FreeEventModelData: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [FreeEventModelDetails]?
}

// MARK: - Datum
struct FreeEventModelDetails: Codable {
    var id, adminID: Int?
    var orderNo: String?
    var eventID, eventCreatedBy, promoterID: Int?
    var date: String?
    var amount: Int?
    var paymentStatus, paymentResponse, currency: String?
    var verifiedPromoterEvent, status: Int?
    var createdAt, updatedAt, eventStatus: String?
    var events: FreeEvents?
    var promoter: Promoter2?

    enum CodingKeys: String, CodingKey {
        case id
        case adminID = "admin_id"
        case orderNo = "order_no"
        case eventID = "event_id"
        case eventCreatedBy = "event_created_by"
        case promoterID = "promoter_id"
        case date, amount
        case paymentStatus = "payment_status"
        case paymentResponse = "payment_response"
        case currency, verifiedPromoterEvent, status
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case eventStatus = "event_status"
        case events, promoter
    }
}

// MARK: - Events
struct FreeEvents: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime, image, description: String?
    var status, verifiedPromoterEvent, isPopular, isCancelled: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var category: FreeCategory?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case image, description, status, verifiedPromoterEvent, isPopular, isCancelled
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case category
    }
}

// MARK: - Category
struct FreeCategory: Codable {
    var id, userID: Int?
    var name: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case name, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}

// MARK: - Promoter
struct Promoter2: Codable {
    var id, userType: Int?
    var firstName, lastName, email, phoneNo: String?
    var companyName, emailVerifiedAt: String?
    var status: Int?
    var userProfile: String?
    var isVerified: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var isEmailVerified: Int?

    enum CodingKeys: String, CodingKey {
        case id
        case userType = "user_type"
        case firstName = "first_name"
        case lastName = "last_name"
        case email
        case phoneNo = "phone_no"
        case companyName = "company_name"
        case emailVerifiedAt = "email_verified_at"
        case status
        case userProfile = "user_profile"
        case isVerified
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
        case isEmailVerified = "is_email_verified"
    }
}
// MARK: - Status Model
struct AdminChangeEventModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    //var data: [PromotionalDetails]?
}
