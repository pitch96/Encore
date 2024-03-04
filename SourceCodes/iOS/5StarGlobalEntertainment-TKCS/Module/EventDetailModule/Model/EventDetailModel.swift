//
//  EventDetailModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 09/02/23.
//

import Foundation
// MARK: - Event detail model
struct StatusChangeModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    //var data: [JSONAny]?
}
// MARK: Refer Link Model
struct ReferLinkModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: [String]?
    var data: String?
}
struct EventDetailModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: EventDetails?
}

// MARK: - DataClass
struct EventDetails: Codable {
    var stripeAccount: StripeAccount?
    var event: Event2?
    var promotionEvent: PromotionEvent?

    enum CodingKeys: String, CodingKey {
        case stripeAccount = "stripe_account"
        case event
        case promotionEvent = "promotion_event"
    }
}

// MARK: - Event
struct Event2: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime: String?
    var image: String?
    var description: String?
    var status, verifiedPromoterEvent, isPopular, isCancelled: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?
    var category: Category2?

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
struct Category2: Codable {
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

// MARK: - StripeAccount
struct StripeAccount: Codable {
    var id: Int?
    var email, stripeAccountid, createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id, email
        case stripeAccountid = "stripe_accountid"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}

// MARK: PromotionEvent
struct PromotionEvent: Codable {
    var id, adminID: Int?
    var orderNo: String?
    var eventID, eventCreatedBy, promoterID: Int?
    var date: String?
    var amount: Int?
    var paymentStatus, paymentResponse, currency: String?
    var status: Int?
    var createdAt, updatedAt: String?

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
    }
}
